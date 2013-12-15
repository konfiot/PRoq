#!/bin/bash

if [ ! -f "arch.img.bz2" ]
then
echo "Downloading image"
wget https://dl.dropboxusercontent.com/s/5nd5k523uvq5ifu/arch.img.bz2
fi

if [ ! -f "kernel-qemu" ]
then
echo "Downloading kernel"
wget http://www.xecdesign.com/downloads/linux-qemu/kernel-qemu
fi

if [ ! -f "id_rsa" ]
then
echo "Downloading RSA key"
wget https://dl.dropboxusercontent.com/s/cf82cjgih3jhzp1/id_rsa
wget $PRIVATE_URL > /dev/null 2>&1
chmod 600 id_rsa
chmod 600 id_rsa_sourceforge
fi

if [ ! -f "arch.img" ]
then
echo "Extracting Image"
bzip2 -d arch.img.bz2
fi

if [ ! -f "system.img" ]
then
echo "Copying image"
cp arch.img system.img
fi

echo "Launching qemu"
qemu-system-arm -kernel kernel-qemu -cpu arm1176 -m 256 -M versatilepb -no-reboot -append "root=/dev/sda5 rw panic=1" -hda system.img -nographic -redir tcp:5555::22 &

sleep 40

echo "Copying files"
scp -r -i id_rsa -o StrictHostKeyChecking=no -P 5555 ./scripts root@localhost:./scripts
scp -r -i id_rsa -o StrictHostKeyChecking=no -P 5555 ./utils/start.sh root@localhost:./
scp -r -i id_rsa -o StrictHostKeyChecking=no -P 5555 ./WebConfiguration/ root@localhost:./

echo "Installing"
ssh root@localhost -o StrictHostKeyChecking=no -p 5555 -i id_rsa "export EDITOR=cat ; yes | pacman -R heirloom-mailx ; yes | pacman -Syu lighttpd python mpd python2-pygame php-cgi php yaourt python2-pip alsa-lib alsa-firmware ttf-dejavu ttf-droid ttf-ubuntu-font-family ttf-linux-libertine ttf-liberation ttf-junicode ttf-freefont ttf-inconsolata ttf-indic-otf ttf-cheapskate ttf-bitstream-vera ttf-arphic-ukai ttf-arphic-uming ; echo 'n\ny' | yaourt -S svox-pico-git ; yes | pip-2.7 install icalendar python-mpd2 ; mkdir /etc/lighttpd/conf.d ; mkdir /var/lib/mpd/music ; touch /var/lib/mpd/mpd.db ; chown -R mpd:mpd  /var/lib/mpd/ ; echo 'music_directory \"/var/lib/mpd/music\"' >> /etc/mpd.conf ; echo 'server.modules += ( \"mod_fastcgi\" ) index-file.names += ( \"index.php\" ) fastcgi.server = ( \".php\" => ((                    \"bin-path\" => \"/usr/bin/php-cgi\",                    \"socket\" => \"/tmp/php.socket\",                    \"max-procs\" => 2,                    \"bin-environment\" => (                      \"PHP_FCGI_CHILDREN\" => \"16\",                      \"PHP_FCGI_MAX_REQUESTS\" => \"10000\"                    ),                    \"bin-copy-environment\" => (                   \"PATH\", \"SHELL\", \"USER\"                    ),                    \"broken-scriptfilename\" => \"enable\"                )))' >> /etc/lighttpd/conf.d/fastcgi.conf ; echo 'include \"conf.d/fastcgi.conf\"' >> /etc/lighttpd/lighttpd.conf ; echo '[Unit]
After=network.target
[Service]
Type=forking
ExecStart=/root/start.sh
[Install]
WantedBy=multi-user.target' > /etc/systemd/system/proq.service ; systemctl enable lighttpd mpd proq ; mv ~/WebConfiguration/* /srv/http/ ; mkdir /srv/http/conf/ ; ln -s /srv/http/conf/ /root/ ; rm .ssh/authorized_keys .ssh/known_hosts ; sed -i 's/sda/mmcblk0p/' /etc/fstab ; reboot"

echo "Compressing"
bzip2 system.img

echo "Uploading"
rsync -e "ssh -o StrictHostKeyChecking=no -i id_rsa_sourceforge" system.img.bz2 konfiot@frs.sourceforge.net:/home/frs/project/smart-wake/Nightly/ --progress

echo "Cleaning"
rm system.img.bz2
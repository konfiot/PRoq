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
chmod 600 id_rsa
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

sleep 25

echo "Copying files"
scp -r -i id_rsa -o StrictHostKeyChecking=no -P 5555 ./scripts root@localhost:./scripts
scp -r -i id_rsa -o StrictHostKeyChecking=no -P 5555 ./WebConfiguration/ root@localhost:./

echo "Installing"
ssh root@localhost -o StrictHostKeyChecking=no -p 5555 -i id_rsa "yes | pacman -Syu lighttpd php-cgi php ; systemctl enable lighttpd ; mkdir /etc/lighttpd/conf.d ; echo ''server.modules += ( \"mod_fastcgi\" ) index-file.names += ( \"index.php\" ) fastcgi.server = ( \".php\" => ((                    \"bin-path\" => \"/usr/bin/php-cgi\",                    \"socket\" => \"/tmp/php.socket\",                    \"max-procs\" => 2,                    \"bin-environment\" => (                      \"PHP_FCGI_CHILDREN\" => \"16\",                      \"PHP_FCGI_MAX_REQUESTS\" => \"10000\"                    ),                    \"bin-copy-environment\" => (                   \"PATH\", \"SHELL\", \"USER\"                    ),                    \"broken-scriptfilename\" => \"enable\"                )))' >> /etc/lighttpd/conf.d/fastcgi.conf ; mv -r ~/WebConfiguration/* /srv/http/ ; rm .ssh/authorized_keys .ssh/known_hosts ; sed -i 's/sda/mmcblk0p/' /etc/fstab ; reboot"

echo "Compressing"
bzip2 system.img

echo "Uploading"
#yes yes | rsync -e ssh system.img.gz konfiot@frs.sourceforge.net:/home/frs/project/smart-wake/Nightly/ --progress

echo "Cleaning"
rm system.img.bz2

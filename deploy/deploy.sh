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

sleep 30

echo "Copying files"
scp -r ./ root@localhost:./ -o StrictHostKeyChecking=no -P 5555 -i id_rsa

echo "Installing"
ssh root@localhost -o StrictHostKeyChecking=no -p 5555 -i id_rsa "yes | pacman -Syu lighttpd ; ls -la . ; rm .ssh/authorized_keys .ssh/known_hosts ; sed -i 's/sda/mmcblk0p/' /etc/fstab ; reboot"

echo "Compressing"
bzip2 system.img

echo "Uploading"
#yes yes | rsync -e ssh system.img.gz konfiot@frs.sourceforge.net:/home/frs/project/smart-wake/Nightly/ --progress

echo "Cleaning"
rm system.img.bz2

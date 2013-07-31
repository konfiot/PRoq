#!/bin/bash
if [ ! -f "arch.img.bz2" ]
then
echo "Downloading image"
wget http://arthurtoussaint.free.fr/arch.img.bz2
fi

if [ ! -f "kernel-qemu" ]
then
echo "Downloading kernel"
wget http://www.xecdesign.com/downloads/linux-qemu/kernel-qemu
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

echo "Installing"
qemu-system-arm -kernel kernel-qemu -cpu arm1176 -m 256 -M versatilepb -no-reboot -append "root=/dev/sda5 rw panic=1" -hda system.img -nographic -redir tcp:5555::22 &
sleep 45
ssh root:root@localhost -p 5555 "pacman -Syu ; reboot"

echo "Compressing"
gzip system.img

echo "Uploading"
yes yes | rsync -e ssh system.img.gz konfiot@frs.sourceforge.net:/home/frs/project/smart-wake/Nightly/ --progress

echo "Cleaning"
rm system.img

#!/bin/bash
if [ ! -f "system.img.zip" ]
then
echo "Downloading image"
wget -O system.img.zip http://archlinuxarm.org/os/rpi/archlinux-hf-2013-06-15.img.zip
fi

if [ ! -f "archlinux-hf-2013-06-15.img" ]
then
echo "Extracting Image"
unzip system.img.zip
fi

if [ ! -f "system.img" ]
then
echo "Copying image"
cp archlinux-hf-2013-06-15.img system.img
fi

if [ ! -d "system" ]
then
mkdir system
fi

echo"Mounting"
sudo mount -o loop,offset=96468992 system.img system/

echo "Installing"
sudo rsync -r --exclude=deploy/  ../ system/home/

echo "Unmounting"
sudo umount system

echo "Compressing"
gzip system.img

echo "Uploading"
rsync -e ssh system.img.gz konfiot@frs.sourceforge.net:/home/frs/project/smart-wake/Nightly/ --progress

echo "Cleaning"
rm system.img.gz
rmdir system

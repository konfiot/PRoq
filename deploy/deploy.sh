#!/bin/bash
if [ ! -f "system.img.zip" ]
then
wget -O system.img.zip http://archlinuxarm.org/os/rpi/archlinux-hf-2013-06-15.img.zip
fi
if [ ! -f "archlinux-hf-2013-06-15.img" ]
then
unzip system.img.zip
fi
if [ ! -d "system" ]
then
mkdir system
fi
sudo mount -o loop,offset=96468992 archlinux-hf-2013-06-15.img system/

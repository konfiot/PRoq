#!/bin/sh
wget -O system.img.zip http://archlinuxarm.org/os/rpi/archlinux-hf-2013-06-15.img.zip
unzip system.img.zip
mkdir system
sudo mount archlinux-hf-2013-06-15.img system
ls system


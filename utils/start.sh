#!/bin/sh
cd "/root/scripts"
./master.py &
./data_refresh.py &
./screenmanager.py &
./sensors.py &

#!/bin/sh
DIR=$( dirname "${BASH_SOURCE[0]}" )
cd $DIR
./update.sh
cd ..
cd "$DIR/scripts"
./master.py &
./data_refresh.py &
./screenmanager.py &

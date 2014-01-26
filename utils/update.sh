#!/bin/sh
cd ~
git clone https://github.com/konfiot/PRoq.git
cp -R PRoq/{scripts,utils/start.sh,utils/update.sh} ./
cp -R PRoq/WebConfiguration /srv/http
rm -r PRoq
systemctl restart proq

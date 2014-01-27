#!/bin/sh
cd ~
git clone https://github.com/konfiot/PRoq.git
cp -R PRoq/{scripts,utils/start.sh,utils} ./
cp -R PRoq/WebConfiguration/* /srv/http
cp PRoq/utils/update.sh utils/update.sh
rm -r PRoq
systemctl restart proq

#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from functions import get
import time
import json
import socket

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)
s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
s.connect("mastersocket")

while 1 :
	(data, data_forecast) = get.weather(conf)
	unread = get.mail(conf)
	news = get.news(conf)
	cal = get.calendar(conf)
	
	s.send(json.dumps([data, data_forecast, unread, news, cal]))
	
	time.sleep(10)

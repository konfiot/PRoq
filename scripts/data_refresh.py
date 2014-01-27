#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from functions import get
import time
import json
import socket
import os

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

# Mise en place des proxies

os.environ["http_proxy"] = "http://" + conf["general"]["http_proxy"] if conf["general"]["http_proxy"] !== "" else ""
os.environ["https_proxy"] = "https://" + conf["general"]["https_proxy"] if conf["general"]["https_proxy"] !== "" else ""

while 1 :
	try :
		unread = get.mail(conf)
		(data, data_forecast) = get.weather(conf)
		news = get.news(conf)
		cal = get.calendar(conf)
	except :
		print "Error"
		continue;
	s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
	s.connect("mastersocket")
	s.send(json.dumps({"request": "new_data", "content": [data, data_forecast, unread, news, cal]}))
	print s.recv(8192)	
	s.shutdown(socket.SHUT_RDWR)
	time.sleep(10)

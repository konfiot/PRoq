#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from functions import get
import time
import json

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

while 1 :
	(data, data_forecast) = get.weather(conf)
	unread = get.mail(conf)
	news = get.news(conf)
	cal = get.calendar(conf)
	
	print json.dumps(data) + "$" + json.dumps(data_forecast) + "$" + str(unread) + "$" + str(news) + "$" + json.dumps(cal)

	time.sleep(10)

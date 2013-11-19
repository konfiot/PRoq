#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import os, socket, json

content = {}

def managedata (json_data) :
	data = {}
	try: 
		data = json.loads(json_data)
	except ValueError: 
		print "Y'a une couille dans ljson quoi"
		return "KO"
	
	if data["request"] == "new_data": 
		content = data["content"]
		return "OK"


s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)

try:
	os.remove("mastersocket")

except OSError:
	pass

s.bind("mastersocket")
s.listen(1)
s.setblocking(0)


while 1 :
	try :
		conn, addr = s.accept()
	except socket.error : 
		continue
	
	try:
		data = conn.recv(8192)
	except socket.error :
		continue


	if data :
		print "Data : " + data
		to_send = managedata(data)
		conn.send(to_send)



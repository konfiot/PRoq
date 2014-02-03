#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import os, socket, json

content = {}
prox = 0
delta = 0
sw = False

def managedata (json_data) :
	global content
	global prox	
	global delta	
	data = {}
	try: 
		data = json.loads(json_data)
	except ValueError: 
		print "Problème durant le parsage du JSON"
		return "KO"
	
	if data["request"] == "new_data": 
		content = data["content"]
		return "OK"
	elif data["request"] == "get_data": 
		try :
			return json.dumps(content)
		except UnboundLocalError:
			return ""

	elif data["request"] == "set_prox_state": 
		prox = data["content"]
		return "OK"
	elif data["request"] == "get_prox_state": 
		return str(prox)

	elif data["request"] == "set_sw_state": 
		sw = data["content"]
		return "OK"
	elif data["request"] == "get_sw_state": 
		return str(sw)

	elif data["request"] == "set_delta": 
		delta += int(data["delta"])
		return "OK"
	elif data["request"] == "get_delta": 
		to_send = str(delta) 		
		delta = 0
		return to_send


s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)

try:
	os.remove("mastersocket")

except OSError:
	pass

s.bind("mastersocket")
s.listen(1)


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
		print "Sent : " + to_send
		conn.send(to_send)



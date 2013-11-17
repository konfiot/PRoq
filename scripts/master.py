#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import os, socket

s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)

try:
	os.remove("mastersocket")

except OSError:
	pass

s.bind("mastersocket")
s.listen(1)

conn, addr = s.accept()

while 1 :
	data = conn.recv(8192)
	if data : 
		print "Data : " + data

#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import spidev
import time
import socket
import json
#import gaugette.rotary_encoder
#import gaugette.switch 

def ReadChannel(channel):
	adc = spi.xfer2([1,(8+channel)<<4,0])
	data = ((adc[1]&3) << 8) + adc[2]
	return data


spi = spidev.SpiDev()
spi.open(0,0)


A_PIN = 7
B_PIN = 9
SW_PIN = 8 

#encoder = gaugette.rotary_encoder.RotaryEncoder.Worker(A_PIN, B_PIN)
#encoder.start()
#switch = gaugette.switch.Switch(SW_PIN)
last_state = None 
THRESOLD = 700
prox_state = 0

while True : 
	adcval = ReadChannel(0)
	milivolts = adcval * ( 3300.0 / 1024.0)
	#delta = encoder.get_delta()
	#sw_state = switch.get_state()
	
	if milivolts >= THRESOLD and prox_state == 0 : # TODO : A simplifier
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_prox_state", "content": 1}))
		prox_state = 1
	elif milivolts < THRESOLD and prox_state == 1: 
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_prox_state", "content": 0}))
		prox_state = 0

#	if delta!=0:
#		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
#		s.connect("mastersocket")
#		s.send(json.dumps({"request": "set_delta", "content": str(delta)}))
#	
#	if sw_state != last_state:
#		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
#		s.connect("mastersocket")
#		s.send(json.dumps({"request": "set_switch_state", "content": str(sw_state)}))
#		last_state = sw_state
	
	time.sleep(0.05)

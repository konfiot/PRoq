#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import spidev
import time
import socket
import json
import wiringpi2

def ReadChannel(channel):
	adc = spi.xfer2([1,(8+channel)<<4,0])
	data = ((adc[1]&3) << 8) + adc[2]
	return data


spi = spidev.SpiDev()
spi.open(0,0)


A_PIN = 7
B_PIN = 9
SW_PIN = 8 

last_state = False
THRESOLD = 700
prox_state = 0

r_seq = 0
old_r_seq = 0
delta = 0
old_delta = 0

wiringpi2.wiringPiSetupGpio()
wiringpi2.pinMode(A_PIN,0)
wiringpi2.pinMode(B_PIN,0)
wiringpi2.pinMode(SW_PIN,0)

while True : 
	adcval = ReadChannel(0)
	milivolts = adcval * ( 3300.0 / 1024.0)
	sw_state = switch.get_state()
	a_state = wiringpi2.digitalRead(A_PIN)
	b_state = wiringpi2.digitalRead(B_PIN)
	sw_state = wiringpi2.digitalRead(SW_PIN)

        r_seq = (a_state ^ b_state) | b_state << 1

	if r_seq != old_r_seq:
		delta = (r_seq - old_r_seq) % 4
		if delta==3:
			delta = -1
		elif delta==2:
			delta = int(math.copysign(delta, old_delta))

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

	if delta!=0:
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_delta", "content": str(delta)}))
	
	if sw_state != last_state:
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_switch_state", "content": str(sw_state)}))
	
	last_state = sw_state
	
	old_r_seq = r_seq
	old_delta = delta
	
	time.sleep(0.05)

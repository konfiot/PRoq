#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import spidev
import time
import socket
import json
#import wiringpi2
import math
import RPi.GPIO as GPIO

first = True
delta = 0

def ReadChannel(channel):
	adc = spi.xfer2([1,(8+channel)<<4,0])
	data = ((adc[1]&3) << 8) + adc[2]
	return data

def enca(arg):
	global first
	global delta
	if GPIO.input(A_PIN) == GPIO.LOW :
		first = True
		return
	if first : first = False
	else : 
		delta += 1
		first = True

def encb(arg):
	global first
	global delta
	if GPIO.input(B_PIN) == GPIO.LOW : 
		first = True
		return
	if first : first = False
	else :
		delta -= 1
		first = True

def unlock(arg) : 
	first = True

spi = spidev.SpiDev()
spi.open(0,0)


A_PIN = 24
B_PIN = 22
SW_PIN = 23 

last_state = False
THRESOLD = 700
prox_state = 0

#wiringpi2.wiringPiSetupGpio()
#wiringpi2.pinMode(A_PIN,0)
#wiringpi2.pinMode(B_PIN,0)
#wiringpi2.pinMode(SW_PIN,0)
#wiringpi2.wiringPiISR(A_PIN, 3, &enca)
#wiringpi2.wiringPiISR(B_PIN, 3, &encb)

GPIO.setmode(GPIO.BCM)
GPIO.setup(A_PIN, GPIO.IN)
GPIO.setup(B_PIN, GPIO.IN)
GPIO.setup(SW_PIN, GPIO.IN)

GPIO.add_event_detect(A_PIN,GPIO.BOTH, callback=enca)
GPIO.add_event_detect(B_PIN,GPIO.BOTH, callback=encb)


while True : 
	adcval = ReadChannel(0)
	milivolts = adcval * ( 3300.0 / 1024.0)

	a_state = 0#not(wiringpi2.digitalRead(A_PIN))
	b_state = 0#not(wiringpi2.digitalRead(B_PIN))
	sw_state = GPIO.input(SW_PIN)#0#int(wiringpi2.digitalRead(SW_PIN))

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
		s.send(json.dumps({"request": "set_sw_state", "content": str(sw_state)}))
	
	last_state = sw_state
	delta = 0
	time.sleep(0.01)

#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import RPi.GPIO as GPIO

def readadc(adcnum, clockpin, mosipin, misopin, cspin):
	if ((adcnum > 7) or (adcnum < 0)):
		return -1
	GPIO.output(cspin, True)

	GPIO.output(clockpin, False)  # start clock low
	GPIO.output(cspin, False)     # bring CS low

	commandout = adcnum
	commandout |= 0x18  # start bit + single-ended bit
	commandout <<= 3    # we only need to send 5 bits here
	for i in range(5):
		if (commandout & 0x80):
			GPIO.output(mosipin, True)
		else:   
			GPIO.output(mosipin, False)
		commandout <<= 1
		GPIO.output(clockpin, True)
		GPIO.output(clockpin, False)

	adcout = 0
	# read in one empty bit, one null bit and 10 ADC bits
	for i in range(12):
		GPIO.output(clockpin, True)
		GPIO.output(clockpin, False)
		adcout <<= 1
		if (GPIO.input(misopin)):
			adcout |= 0x1

	GPIO.output(cspin, True)

	adcout /= 2       # first bit is 'null' so drop it
	return adcout

SPICLK = 18
SPIMISO = 23
SPIMOSI = 24
SPICS = 25

GPIO.setup(SPIMOSI, GPIO.OUT)
GPIO.setup(SPIMISO, GPIO.IN)
GPIO.setup(SPICLK, GPIO.OUT)
GPIO.setup(SPICS, GPIO.OUT)

prox_state = False

while True : 
	adcval = readadc(0, SPICLK, SPIMOSI, SPIMISO, SPICS)
	millivolts = adcval * ( 3300.0 / 1024.0)

	if milivolts >= THRESOLD and prox_state == False :
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_prox_state", "content": True}))
		prox_state = True
	else if milivolts < THRESOLD and prox_state == True: 
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "set_prox_state", "content": False}))
		prox_state = False


	time.sleep(0.05)

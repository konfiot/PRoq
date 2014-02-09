#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import subprocess
import os
import time
import json
from mpd import MPDClient
import alsaaudio
import socket

def wait_for_dismiss () :
	mixer = alsaaudio.Mixer(control="PCM")
	mixer.setmute(1)
	for i in range(mixer.getvolume()) : 
		try:
			mixer.setvolume(i)
			s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
			s.connect("mastersocket")
			s.send(json.dumps({"request": "get_prox_state"}))
			prox = int(s.recv(4096))
			if prox == 1 :
				mixer.setvolume(mixer.getvolume())
				return
		except  :
			pass
		time.sleep(0.1)
	mixer.setvolume(mixer.getvolume())
	while True :
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "get_prox_state"}))
		prox = int(s.recv(4096))
		if prox == 1 :
			return


# Ouverture du fichier de configuration

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

client = MPDClient()
client.connect("localhost", 6600)
client.clear()
client.update()
client.add(conf["general"]["music_path"])

client.play()
wait_for_dismiss()

client.disconnect()

subprocess.call(["./tts.py"])

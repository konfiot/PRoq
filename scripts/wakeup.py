#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import subprocess
import os
import time
import json
from mpd import MPDClient
import alsaaudio

def wait_for_dismiss (client) :
	mixer = alsaaudio.Mixer(control="PCM")
	mixer.setmute(1)
	for i in range(100) : 
		try:
			client.setvol(i)
			mixer.setmute(0)
		except  :
			pass
		time.sleep(0.1)
	time.sleep(10)


# Ouverture du fichier de configuration

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

client = MPDClient()
client.connect("localhost", 6600)
client.clear()
client.update()
client.add(conf["general"]["music_path"])

client.play()
wait_for_dismiss(client)

client.disconnect()

subprocess.call(["./tts.py"])

#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import subprocess
import os
import time
import json
from mpd import MPDClient

def wait_for_dismiss (client) :
	#for i in range(100) : 
	#	try:
	#		client.setvol(i)
	#	except  :
	#		pass
	#	time.sleep(0.1)
	time.sleep(10)


# Ouverture du fichier de configuration

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

client = MPDClient()
client.connect("localhost", 6600)
client.clear()
client.crossfade(5)
client.add(conf["general"]["music_path"])

client.play()
wait_for_dismiss(client)

client.disconnect()

subprocess.call(["./tts.py"])

#!/usr/bin/python
# -*- coding: utf-8 -*-

import subprocess
import os
import time


def wait_for_dismiss () :
	time.sleep(10)


# Ouverture du fichier de configuration

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)


process = subprocess.Popen(["mplayer", "-loop", "0", conf["general"]["music_path"]])

wait_for_dismiss()

process.terminate()

subprocess.call(["./tts.py"])

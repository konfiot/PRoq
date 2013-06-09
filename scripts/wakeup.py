#!/usr/bin/python
# -*- coding: utf-8 -*-

import subprocess
import os
import time


def wait_for_dismiss () :
	time.sleep(10)

process = subprocess.Popen(["mplayer", "-loop", "0", "ringtone"])

wait_for_dismiss()

process.terminate()

subprocess.call(["./tts.py"])

#!/usr/bin/python
# -*- coding: utf-8 -*-

import subprocess
import pyglet

def wait_for_dismiss () :
    return

ring = pyglet.media.load('ringtone.mp3', streaming=False)
explosion.play()

wait_for_dismiss()

subprocess.call(["./tts.py"])
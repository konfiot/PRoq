#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from pygame import Surface, font, display, surfarray
import json
import urllib
import StringIO
import time
from datetime import datetime, date
from functions import get, render, datatable
import sys
import socket
import fcntl
import struct
from alsaaudio import Mixer 
import math
from mpd import MPDClient

print "Import"

def get_ip_address(ifname):
	s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	return socket.inet_ntoa(fcntl.ioctl(
		s.fileno(),
		0x8915,
		struct.pack('256s', ifname[:15])
	)[20:24])

def hex_to_rgb(value):
	value = value.lstrip('#')
	lv = len(value)
	return tuple(int(value[i:i+lv/3], 16) for i in range(0, lv, lv/3))

def color_surface(surface, (red, green, blue)):
	surface.convert_alpha()
	arr = surfarray.pixels3d(surface)
	arr[:,:,0] = red
	arr[:,:,1] = green
	arr[:,:,2] = blue

def _linux_set_time(time_tuple):
    import ctypes
    import ctypes.util
    import time

    # /usr/include/linux/time.h:
    #
    # define CLOCK_REALTIME                     0
    CLOCK_REALTIME = 0

    # /usr/include/time.h
    #
    # struct timespec
    #  {
    #    __time_t tv_sec;            /* Seconds.  */
    #    long int tv_nsec;           /* Nanoseconds.  */
    #  };
    class timespec(ctypes.Structure):
        _fields_ = [("tv_sec", ctypes.c_long),
                    ("tv_nsec", ctypes.c_long)]

    librt = ctypes.CDLL(ctypes.util.find_library("rt"))

    ts = timespec()
    ts.tv_sec = int( time.mktime( datetime( *time_tuple[:6]).timetuple() ) )
    ts.tv_nsec = time_tuple[6] * 1000000 # Millisecond to nanosecond

    # http://linux.die.net/man/3/clock_settime
    librt.clock_settime(CLOCK_REALTIME, ctypes.byref(ts))

def show_menu(background, back_color):
	dt = datetime.today()
	data = json.load(urllib.urlopen("http://127.0.0.1/functions/cron.php?next"))
	dr = datetime.fromtimestamp(data["heure"])
	i = 0
	while True :
		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "get_delta"}))
		delta = int(s.recv(4096))

		s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
		s.connect("mastersocket")
		s.send(json.dumps({"request": "get_sw_state"}))
		sw_state = int(s.recv(4096))


		background.fill(back_color)
		render.render(get_ip_address('eth0'), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 0, 320, 60)
		
		if i == 0 : 
			render.render(dt.strftime("%H:%M"), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 60, 320, 120)
			dt = dt.replace(minute = (dt.minute + delta) % 60, hour = dt.hour + int(math.floor((dt.minute + delta) / 60)))
		elif i == 1 :
			render.render(dr.strftime("%H:%M"), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 60, 320, 120)
			dr = dr.replace(minute = (dr.minute + delta) % 60, hour = dr.hour + int(math.floor((dr.minute + delta) / 60)))
		if sw_state :
			i+= 1

		screen.blit(background, (0, 0))
		display.flip()
		time.sleep(0.1)

		if i >= 2 :
			_linux_set_time(dt.timetuple())
			break

# Initialisation

display.init()
font.init()
screen = display.set_mode([320, 240])
background = Surface(screen.get_size())
background = background.convert()

# Récupération de la config

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

# Définition des polices
font_filename = font.match_font(conf["general"]["font"])
font = font.Font(font_filename, 135)
font_time = font.Font(font_filename, 135)


# Definition et coloration des images

image_temp = image.load("images/misc/temp.png")
image_rise = image.load("images/misc/rise.png")
image_set = image.load("images/misc/set.png")
image_mail = image.load("images/misc/mail.png")
image_news = image.load("images/misc/news.png")
image_cal = image.load("images/misc/cal.png")
color_surface(image_temp, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_rise, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_set, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_mail, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_news, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_cal, hex_to_rgb(conf["general"]["front_color"]))		

table = datatable.DataTable(background, font, hex_to_rgb(conf["general"]["front_color"]), hex_to_rgb(conf["general"]["back_color"]), 0, 120, 200, 128, 3, 2, 10, 5)

client = MPDClient()
client.connect("localhost", 6600)


def get_data(): 
	s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
	s.connect("mastersocket")
	s.send(json.dumps({"request": "get_data"}))
	data = s.recv(8192)
	raw = json.loads(data)
	if raw :
		(data, data_forecast, unread, news, cal) = raw
		return (data, data_forecast, unread, news, cal)
	else :
		return False

def update(): 
	raw = get_data()

	if raw :
		(data, data_forecast, unread, news, cal) = raw

		image_weather = image.load("images/weather/" + data_forecast["list"][0]["weather"][0]["icon"] + ".png")
		color_surface(image_weather, hex_to_rgb(conf["general"]["front_color"]))

		background.fill(hex_to_rgb(conf["general"]["back_color"]))

		background.blit(image_weather, image_weather.get_rect())
                
		render.render(datetime.today().strftime("%H:%M"), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 120, 320, 120)

		table.update([{"image": image_temp, "data": str(round(data_forecast["list"][0]["temp"]["day"], 1))}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M")}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunset"]).strftime("%H:%M")}, {"image": image_mail, "data": str(unread[0])}, {"image": image_news, "data": str(news)}, {"image": image_cal, "data": str(cal[0])}])

		screen.blit(background, (0, 0))
		display.flip()
	else :
		render.render(get_ip_address('eth0'), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 0, 320, 240)
		screen.blit(background, (0, 0))
                display.flip()

# Boucle de rafraichissement

mixer = Mixer(control="PCM")

while True : 
	time.sleep(0.1)
	update()

	s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
	s.connect("mastersocket")
	s.send(json.dumps({"request": "get_delta"}))
	delta = int(s.recv(4096))

	if delta != 0 :
		mixer.setvolume(min(100, mixer.getvolume()[0] + delta))
		client.clear()
		client.add("blup.mp3")
		client.play()


	s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
	s.connect("mastersocket")
	s.send(json.dumps({"request": "get_sw_state"}))
	data = int(s.recv(4096))
	print data
	if data : 
		show_menu(background, hex_to_rgb(conf["general"]["back_color"]))

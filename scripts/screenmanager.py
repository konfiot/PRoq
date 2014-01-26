#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import pygame
import json
import urllib
import StringIO
import time
from datetime import datetime, date
from functions import get, menu, render, datatable
import sys
import socket
import fcntl
import struct

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
	arr = pygame.surfarray.pixels3d(surface)
	arr[:,:,0] = red
	arr[:,:,1] = green
	arr[:,:,2] = blue

def show_menu(background, back_color):
	dt = datetime.today()
	while True :
		background.fill(back_color)
		render.render(get_ip_address('eth0'), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 0, 320, 60)
		render.render(dt.strftime("%H:%M"), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 60, 320, 120)
		screen.blit(background, (0, 0))
		pygame.display.flip()
		dt = dt.replace(minute = (dt.minute + 1) % 60)
		time.sleep(1)

# Initialisation

pygame.font.init()
screen = pygame.display.set_mode((320, 240))
background = pygame.Surface(screen.get_size())
background = background.convert()

# Récupération de la config

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

# Définition des polices
font_filename = pygame.font.match_font(conf["general"]["font"])
font = pygame.font.Font(font_filename, 135)
font_time = pygame.font.Font(font_filename, 135)


# Definition et coloration des images

image_temp = pygame.image.load("images/misc/temp.png")
image_rise = pygame.image.load("images/misc/rise.png")
image_set = pygame.image.load("images/misc/set.png")
image_mail = pygame.image.load("images/misc/mail.png")
image_news = pygame.image.load("images/misc/news.png")
image_cal = pygame.image.load("images/misc/cal.png")
color_surface(image_temp, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_rise, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_set, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_mail, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_news, hex_to_rgb(conf["general"]["front_color"]))
color_surface(image_cal, hex_to_rgb(conf["general"]["front_color"]))		

config_menu = menu.Menu(screen, ["Modifier l'heure", "Durée du snooze", "Modifier l'action du snooze"], None, hex_to_rgb(conf["general"]["front_color"]), hex_to_rgb(conf["general"]["back_color"]))
table = datatable.DataTable(background, font, hex_to_rgb(conf["general"]["front_color"]), hex_to_rgb(conf["general"]["back_color"]), 0, 120, 200, 128, 3, 2, 10, 5)

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

		image_weather = pygame.image.load("images/weather/" + data_forecast["list"][0]["weather"][0]["icon"] + ".png")
		color_surface(image_weather, hex_to_rgb(conf["general"]["front_color"]))

		background.fill(hex_to_rgb(conf["general"]["back_color"]))

		background.blit(image_weather, image_weather.get_rect())
                
		render.render(datetime.today().strftime("%H:%M"), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 120, 320, 120)

		table.update([{"image": image_temp, "data": str(round(data_forecast["list"][0]["temp"]["day"], 1))}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M")}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunset"]).strftime("%H:%M")}, {"image": image_mail, "data": str(unread[0])}, {"image": image_news, "data": str(news)}, {"image": image_cal, "data": str(cal[0])}])

		screen.blit(background, (0, 0))
		pygame.display.flip()
	else :
		render.render(get_ip_address('eth0'), font_time, background, hex_to_rgb(conf["general"]["front_color"]), 0, 0, 320, 240)
		screen.blit(background, (0, 0))
                pygame.display.flip()

# Boucle de rafraichissement

while True : 
	time.sleep(0.1)
	update()
	show_menu(background, hex_to_rgb(conf["general"]["back_color"]))
	#config_menu.show()
	#config_menu.select_delta(2)
	#time.sleep(1)	
	#config_menu.hide()
	for event in pygame.event.get():
		if event.type == pygame.QUIT:
			sys.exit()

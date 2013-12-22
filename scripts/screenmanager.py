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


# Definition des images

image_temp = pygame.image.load("images/misc/temp.png")
image_rise = pygame.image.load("images/misc/rise.png")
image_set = pygame.image.load("images/misc/set.png")
image_mail = pygame.image.load("images/misc/mail.png")
image_news = pygame.image.load("images/misc/news.png")
image_cal = pygame.image.load("images/misc/cal.png")


config_menu = menu.Menu(screen, ["Modifier l'heure", "Durée du snooze", "Modifier l'action du snooze"], font)
table = datatable.DataTable(background, font, 0, 160, 160, 120, 3, 2, 10, 5)

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
		# Collage des images
		background.fill((0, 0, 0))

		table.update([{"image": image_temp, "data": str(round(data_forecast["list"][0]["temp"]["day"], 1))}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M")}, {"image": image_rise, "data": datetime.fromtimestamp(data["sys"]["sunset"]).strftime("%H:%M")}, {"image": image_mail, "data": str(unread)}, {"image": image_news, "data": str(news)}, {"image": image_cal, "data": str(cal[0])}])

		"""background.blit(image_weather, image_weather.get_rect())
		background.blit(image_temp, image_temp.get_rect(centerx=130))
		background.blit(image_rise, image_rise.get_rect(centerx=190, centery=22))
		background.blit(image_set, image_set.get_rect(centerx=260, centery=22))
		background.blit(image_mail, image_mail.get_rect(centerx=125, centery=60))
		background.blit(image_news, image_news.get_rect(centerx=190, centery=60))
		background.blit(image_cal, image_cal.get_rect(centerx=260, centery=60))

		# On ajoute l'heure
		
		render.render(datetime.today().strftime("%H:%M"), font_time, background, (255,255,255), 0, 120, 320, 120)
		
		# On ajoute la température

		render.render(str(round(data_forecast["list"][0]["temp"]["day"], 1)), font, background, (255,255,255), 140, 20, 30, 14)
		
		# On ajoute les image de lever et de coucher du soleil

		render.render(datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M"), font, background, (255,255,255), 210, 20, 30, 14)

		render.render(datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M"), font, background, (255,255,255), 280, 20, 30, 14)

		# On ajoute le compteur des mails non lus

		render.render(str(unread), font, background, (255,255,255), 140, 52, 30, 14)

		# On met aussi les news

		render.render(str(news), font, background, (255,255,255), 210, 52, 30, 14)

		# On ajoute le compteur d'évènements dans la journée

		render.render(str(cal[0]), font, background, (255,255,255), 280, 52, 30, 14)"""

		screen.blit(background, (0, 0))
		pygame.display.flip()
	else :
		return False

# Boucle de rafraichissement

while 1 : 
	time.sleep(0.1)
	update()

	#config_menu.show()
	#config_menu.select_delta(2)
	#config_menu.hide()
	for event in pygame.event.get():
		if event.type == pygame.QUIT:
			sys.exit()

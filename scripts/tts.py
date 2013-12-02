#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

import urllib
import json
import subprocess
import socket
from functions import get
from mpd import MPDClient

def get_weather_string (id) :
	string = "Non reconnu"
	if id == 200 :
		string = "Orage et pluie faible"
	elif id == 201 :
		string = "Orage et pluie"
	elif id == 202 :
		string = "Orage et pluie importante"
	elif id == 210 :
		string = "Orage faible"
	elif id == 211 :
		string = "Orage violent"
	elif id == 221 :
		string = "Orage"
	elif id == 230 or id == 231 or id == 232 :
		string = "Orage avec bruine"
	elif id >= 300 and id <= 321 :
		string = "Bruine"
	elif id == 500 :
		string = "Pluie faible"
	elif id == 501 :
		string = "Pluie modérée"
	elif id == 502 :
		string = "Pluie forte"
	elif id == 503 :
		string = "Pluie très forte"
	elif id == 504 :
		string = "Pluie extrème"
	elif id == 511 :
		string = "Pluie verglaçante"
	elif id == 520 :
		string = "Petite averse de pluie"
	elif id == 521 :
		string = "Averse de pluie"
	elif id == 522 :
		string = "Grosse averse de plue"
	elif id == 600 :
		string = "Neige faible"
	elif id == 601 :
		string = "Neige"
	elif id == 602 :
		string = "Neige forte"
	elif id == 611 :
		string = "Grésil"
	elif id == 621 :
		string = "Averse de neige"
	elif id == 701 :
		string = "Brouillard"
	elif id == 711 :
		string = "Brume"
	elif id == 721 :
		string = "Brume"
	elif id == 731 :
		string = "Tourbillons de poussière"
	elif id == 741 :
		string = "Brouillard"
	elif id == 800 :
		string = "Ciel clair"
	elif id == 801 :
		string = "Quelques nuages"
	elif id == 802 :
		string = "Nuages épars"
	elif id == 803 :
		string = "Éclaircies"
	elif id == 804 :
		string = "Ciel couvert"
	elif id == 900 :
		string = "Tornade"
	elif id == 901 :
		string = "Tempête tropicale"
	elif id == 902 :
		string = "Ouragan"
	elif id == 903 :
		string = "Froid extrème"
	elif id == 904 :
		string = "Chaleur extrème "
	elif id == 905 :
		string = "Beaucoup de vent"
	elif id == 906 :
		string = "Grêle"

	
	return string

# Ouverture du fichier de configuration

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

def get_data(): 
	s = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
	s.connect("mastersocket")
	s.send(json.dumps({"request": "get_data"}))
	data = s.recv(8192)
	(data, data_forecast, unread, news, cal) = json.loads(data)

	return (data, data_forecast, unread, news, cal)

(data, data_forecast, unread, news, cal) = get_data()

# Gestion Météo

id = data["weather"][0]["id"]

weather_string = get_weather_string(id);

# Synthèse vocale

tosay = "Temps prévu pour aujourd'hui : ".decode("utf-8") + weather_string.decode("utf-8") + ". Vous avez " + str(unread) + "Messages non lus. " + str(news) + " nouvelles non lues et " + str(cal[0]) + " évènements aujourd'hui : ".decode("utf-8") + cal[1].decode("utf-8")

client = MPDClient()
client.connect("localhost", 6600)

subprocess.call(["pico2wave", "-l", "fr-FR", "-w" "/var/lib/mpd/music/temp.wav", tosay.encode("utf-8")])
client.clear()
client.update()
client.add("temp.wav")
client.play()
client.disconnect()

#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from Tkinter import *
import Image, ImageTk
import json
import urllib
import StringIO
from datetime import datetime, date
from functions import get

root = Tk()

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)

def update_time () :
	label_time.configure(text=datetime.today().strftime("%H:%M"))
	label_time.after(1000, update_time)

def update() :
	(data, data_forecast) = get.weather(conf)
	image_ = Image.open("images/weather/" + data_forecast["list"][0]["weather"][0]["icon"] + ".png")
	tkpi_ = ImageTk.PhotoImage(image_)
	label_image.configure(image=tkpi)

	label_temp.configure(text=round(data_forecast["list"][0]["temp"]["day"], 1))

	label_time_rise.configure(text=datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M"))

	label_time_set.configure(text=datetime.fromtimestamp(data["sys"]["sunset"]).strftime("%H:%M"))

	label_mail.configure(text=get.mail(conf))
	
	label_cal.configure(text=get.calendar(conf)[0])

	root.after(10000, update)


# On met la fenêtre en plein écran

w, h = 320, 240
#root.overrideredirect(1)
root.geometry("%dx%d+0+0" % (w, h))
root.configure(background='black')

# On va chercher la météo

(data, data_forecast) = get.weather(conf) 

# On ouvre l'image

image = Image.open("images/weather/" + data_forecast["list"][0]["weather"][0]["icon"] + ".png")
tkpi = ImageTk.PhotoImage(image)

label_image = Label(root, image=tkpi, background="black")
label_image.place(x=-15,y=0,width=w*50/100,height=h*50/100)

# On ajoute l'heure

label_time = Label(root, background="black", foreground="white", text=datetime.today().strftime("%H:%M"), font=("Helvetica", 95))
label_time.place(x=0, y=120, width=w, height=h*50/100)

# On ajoute la température

image_temp = Image.open("images/misc/temp.png")
tkpi_temp = ImageTk.PhotoImage(image_temp)

label_image_temp = Label(root, image=tkpi_temp, background="black")
label_image_temp.place(x=120,y=-10,width=w*25/100,height=h*25/100)

label_temp = Label(root, background="black", foreground="white", text=round(data_forecast["list"][0]["temp"]["day"], 1))
label_temp.place(x=165, y=2, width=w*15/100,height=h*15/100)

# On ajoute les image de lever et de coucher du soleil

image_rise = Image.open("images/misc/rise.png")
tkpi_rise = ImageTk.PhotoImage(image_rise)

label_image_rise = Label(root, image=tkpi_rise, background="black")
label_image_rise.place(x=120,y=30,width=w*25/100,height=h*25/100)

label_time_rise = Label(root, background="black", foreground="white", text=datetime.fromtimestamp(data["sys"]["sunrise"]).strftime("%H:%M"))
label_time_rise.place(x=170, y=42, width=w*15/100,height=h*15/100)

image_set = Image.open("images/misc/set.png")
tkpi_set = ImageTk.PhotoImage(image_set)

label_image_set = Label(root, image=tkpi_set, background="black")
label_image_set.place(x=210,y=30,width=w*25/100,height=h*25/100)

label_time_set = Label(root, background="black", foreground="white", text=datetime.fromtimestamp(data["sys"]["sunset"]).strftime("%H:%M"))
label_time_set.place(x=260, y=42, width=w*15/100,height=h*15/100)

# On ajoute le compteur des mails non lus

image_mail = Image.open("images/misc/mail.png")
tkpi_mail = ImageTk.PhotoImage(image_mail)

label_image_mail = Label(root, image=tkpi_mail, background="black")
label_image_mail.place(x=120,y=70,width=w*25/100,height=h*25/100)

unread = get.mail(conf)

label_mail = Label(root, background="black", foreground="white", text=unread)
label_mail.place(x=170, y=80, width=w*10/100,height=h*15/100)

# On ajoute le compteur d'évènements dans la journée

image_cal = Image.open("images/misc/cal.png")
tkpi_cal = ImageTk.PhotoImage(image_cal)

label_image_cal = Label(root, image=tkpi_cal, background="black")
label_image_cal.place(x=210,y=70,width=w*25/100,height=h*25/100)

cal = get.calendar(conf)

label_cal = Label(root, background="black", foreground="white", text=cal[0]		)
label_cal.place(x=260, y=80, width=w*10/100,height=h*15/100)

# On lance la fenêtre

root.after(10000, update)
label_time.after(1000, update_time)

root.mainloop()

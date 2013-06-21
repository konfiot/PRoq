#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from Tkinter import *
import Image, ImageTk
import json
import urllib
import StringIO

root = Tk()

conf_file = open("../conf/wake.json")
conf = json.load(conf_file)


# On met la fenêtre en plein écran

w, h = root.winfo_screenwidth(), root.winfo_screenheight()
root.overrideredirect(1)
root.geometry("%dx%d+0+0" % (w, h))
root.configure(background='black')

# On va chercher la météo

req = urllib.urlopen("http://api.openweathermap.org/data/2.5/weather?q=" + conf["weather"]["location"]);
data = json.load(req)

# On ouvre l'image

reqimg = urllib.urlopen("http://openweathermap.org/img/w/"+ data["weather"][0]["icon"] + ".png")

image = Image.open(StringIO.StringIO(reqimg.read()))
tkpi = ImageTk.PhotoImage(image)
 
label_image = Label(root, image=tkpi)
label_image.place(x=0,y=0,width=w,height=h)


# On lance la fenêtre
root.mainloop()
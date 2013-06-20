#!/usr/bin/python2.7
# -*- coding: utf-8 -*-

from Tkinter import *

root = Tk()

w, h = root.winfo_screenwidth(), root.winfo_screenheight()
# use the next line if you also want to get rid of the titlebar
root.overrideredirect(1)
root.geometry("%dx%d+0+0" % (w, h))
root.configure(background='black')

root.mainloop()

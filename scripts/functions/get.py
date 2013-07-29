import imaplib
import urllib, urllib2
from icalendar import Calendar, Event, vDDDTypes
from datetime import datetime, date
import json
import re

def mail (conf) :
	mail_conf = conf["mail"]
	
	if mail_conf["ssl"] :
		obj = imaplib.IMAP4_SSL(mail_conf["server"], mail_conf["port"])
	else :
		obj = imaplib.IMAP4_SSL(mail_conf["server"], mail_conf["port"])

	obj.login(mail_conf["username"], mail_conf["passwd"])
	obj.select()
	return len(obj.search(None, 'UnSeen')[1][0].split())

def calendar (conf) :
	rdv = ""
	req = urllib.urlopen(conf["calendar"]["url"])
	gcal = Calendar.from_ical(req.read())

	i = 0

	for component in gcal.walk():
		if component.name == "VEVENT" :
			if type(vDDDTypes.from_ical(component.get('dtstart'))) == type(date.today()) :
				start = vDDDTypes.from_ical(component.get('dtstart'))
				end = vDDDTypes.from_ical(component.get('dtend'))
			elif type(vDDDTypes.from_ical(component.get('dtstart'))) == type(datetime.today()) :
				start = vDDDTypes.from_ical(component.get('dtstart')).date()
				end = vDDDTypes.from_ical(component.get('dtend')).date()

			if date.today() >= start and date.today() <= end :
				rdv += component.get("summary") + ", "
				i += 1
	return (i, rdv)

def weather(conf) : 
	req = urllib.urlopen("http://api.openweathermap.org/data/2.5/weather?q=" + conf["weather"]["location"]);
	data = json.load(req)

	req = urllib.urlopen("http://api.openweathermap.org/data/2.5/forecast/daily?units=metric&cnt=1&q=" + conf["weather"]["location"]);
	data_forecast = json.load(req)

	return (data, data_forecast)

def newsblur_get_sessid(conf) : 
	req = urllib.urlopen("http://www.newsblur.com/api/login", urllib.urlencode({"username" : conf["news"]["user"], "password": conf["news"]["passwd"]}))
	data = json.load(req)
	if data["code"] == 1 :
		return re.findall(r"(newsblur_sessionid=.+?);", req.info()["Set-Cookie"])
	else : 
		return false
 
def news(conf) : 
	if conf["news"]["provider"] == "newsblur" :
		cookie = newsblur_get_sessid(conf)
		req = urllib2.Request("http://www.newsblur.com/reader/refresh_feeds", None, {"Cookie" : cookie[0]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		unread = 0	
		for i in data["feeds"] : 
			unread += data["feeds"][i]["nt"]
		return unread
	elif conf["news"]["provider"] == "theoldreader" :
		req = urllib.urlopen("https://theoldreader.com/accounts/ClientLogin", urllib.urlencode({"accountType" : "HOSTED", "service": "reader", "output": "json", "Email" : conf["news"]["user"], "Passwd": conf["news"]["passwd"]}))
		data = json.load(req)
		req = urllib2.Request("https://theoldreader.com/reader/api/0/unread-count?output=json", None, {"Authorization" : "GoogleLogin auth=" + data["Auth"]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		return data["max"]
	elif conf["news"]["provider"] == "commafeed" :
		req = urllib.urlopen("https://"+ conf["news"]["user"] + ":" + conf["news"]["passwd"] + "@www.commafeed.com/rest/category/get")
		data = json.load(req)
		unread = 0
		for i in data["feeds"] : 
			unread += i["unread"]
		return unread
		
	elif conf["news"]["provider"] == "bazqux" :
		req = urllib.urlopen("https://bazqux.com/accounts/ClientLogin", urllib.urlencode({"Email" : conf["news"]["user"], "Passwd": conf["news"]["passwd"]}))
		auth_token = re.findall(r"Auth=(.+)", req.read())
		req = urllib2.Request("https://bazqux.com/reader/api/0/unread-count?output=json", None, {"Authorization" : "GoogleLogin auth=" + auth_token[0]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		return data["unreadcounts"][0]["count"]

	elif conf["news"]["provider"] == "inoreader" :
		req = urllib.urlopen("https://inoreader.com/accounts/ClientLogin", urllib.urlencode({"Email" : conf["news"]["user"], "Passwd": conf["news"]["passwd"]}))
		auth_token = re.findall(r"Auth=(.+)", req.read())
		req = urllib2.Request("https://inoreader.com/reader/api/0/unread-count?output=json", None, {"Authorization" : "GoogleLogin auth=" + auth_token[0]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		return data["unreadcounts"][0]["count"]

	elif conf["news"]["provider"] == "feedhq" :
		req = urllib.urlopen("https://feedhq.org/accounts/ClientLogin", urllib.urlencode({"Email" : conf["news"]["user"], "Passwd": conf["news"]["passwd"]}))
		auth_token = re.findall(r"Auth=(.+)", req.read())
		req = urllib2.Request("https://feedhq.org/reader/api/0/unread-count?output=json", None, {"Authorization" : "GoogleLogin auth=" + auth_token[0]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		return data["unreadcounts"][len(data["unreadcounts"])-1]["count"]

	elif conf["news"]["provider"] == "selfoss" :
		req = urllib2.urlopen(conf["news"]["root"] + "/sources/stats/")
		data = json.load(req)
		unread = 0
		for i in data : 
			unread += int(i["unread"])
		return unread

	elif conf["news"]["provider"] == "ttrss" :
		req = urllib2.urlopen(conf["news"]["root"] + "/api/", '{"op":"login","user":"' + conf["news"]["user"] +'","password":"' + conf["news"]["passwd"] + '"}')
		data = json.load(req)
		req = urllib2.urlopen(conf["news"]["root"] + "/api/", '{"op":"getUnread","sid":"' + data["content"]["session_id"] +'"}')
		data = json.load(req)
		return data["content"]["unread"]

	elif conf["news"]["provider"] == "kouio" :
		req = urllib2.Request("https://kouio.com/api/subscriptions?format=json", None, {"Authorization" : "Token " + conf["news"]["user"]})
		resp = urllib2.urlopen(req)
		data = json.load(resp)
		unread = 0
		for i in data : 
			unread += int(i["unread"])
		return unread

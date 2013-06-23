import imaplib
import urllib
from icalendar import Calendar, Event, vDDDTypes
from datetime import datetime, date

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

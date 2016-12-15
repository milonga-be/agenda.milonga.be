#!/bin/sh
SOURCE=http://www.google.com/calendar/ical
SUFFIX=%40group.calendar.google.com/public/basic.ics
DESTIN=~/apps/agenda.milonga.be/calendars

GET $SOURCE/28g96a9ll24jlhgu9tuhr90g98$SUFFIX > $DESTIN/milonga.ics
GET $SOURCE/85r6bg7tmis832th7cr843esfc$SUFFIX > $DESTIN/festivals.ics

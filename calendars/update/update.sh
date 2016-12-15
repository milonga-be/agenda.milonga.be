#!/bin/sh
SOURCE=http://www.google.com/calendar/ical
SUFFIX=%40group.calendar.google.com/public/basic.ics
DESTIN=~/apps/agenda.milonga.be/calendars
TMPDIR=$DESTIN/update/temp
GREP=/bin/grep


download(){
	URL=$1
	FILE=$2
	TEMP=$TMPDIR/$$.tmp

	# echo GET $URL ...
	GET $URL > $TEMP
	if [ ! -s $TEMP ] ; then
		echo ERROR: Could not update $file - download was empty
	elif [ `$GREP -c "VCALENDAR" $TEMP` -lt 1 ] ; then
		echo ERROR: Could not update $file - not a calendar file
	else
		rm -f $FILE
		mv $TEMP $FILE
	fi
}

download $SOURCE/28g96a9ll24jlhgu9tuhr90g98$SUFFIX $DESTIN/milonga.ics
#download $SOURCE/85r6bg7tmis832th7cr843esfc$SUFFIX $DESTIN/festivals.ics

curl -s http://agenda.milonga.be > /dev/null

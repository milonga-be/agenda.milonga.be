<?php
include("../../lib/template.inc");
$debug=true;

function update_cal($calid,$destin){
	$gcalroot="https://calendar.google.com/calendar/ical";
	$suffix="%40group.calendar.google.com/public/basic.ics";
	$caldir="../calendars";

	$inurl="$gcalroot/$calid$suffix";
	$outfile="$caldir/$destin.ics";

	$oldsize=filesize($outfile);
	echo "<p>OLD SIZE = $oldsize (" . txt_shortenurl($outfile,30) . ")</p>";
	$caltext=graburl($inurl,true,60,"calendar_$destin");
	$newsize=strlen($caltext);
	
	echo "<p>NEW SIZE =  $newsize  (" . txt_shortenurl($inurl,30) . ")</p>";
	if(/*$oldsize<>$newsize AND*/ $newsize > 1000){
		echo "Writing [$outfile]!";
		file_put_contents($outfile,$caltext);
		exec("rm -rf ../cache/*.html");
		exec("rm -rf ../cache/*.spc");
		exec("rm -rf ../*/cache/*.html");
		graburl("http://agenda.milonga.be/filter.php");
	} else {
		echo "Nothing to do";
	}

}

tmpl_header("Update Calendar");
update_cal("28g96a9ll24jlhgu9tuhr90g98","milonga");
tmpl_footer();

// https://www.google.com     /calendar/ical/28g96a9ll24jlhgu9tuhr90g98%40group.calendar.google.com/public/basic.ics
// https://calendar.google.com/calendar/ical/28g96a9ll24jlhgu9tuhr90g98%40group.calendar.google.com/public/basic.ics
 ?>
<?php

include_once("../../lib/template.inc");

include_once("../../lib/class_mutt.inc");

tmpl_setbase("_tpl");

tmpl_header("Alert the organizers");

$debug=true;

$weeks=getparam("weeks",2);

$confirm=getparam("confirm");

$url_agenda="http://agenda.milonga.be/filter.php?weeks=$weeks";

$html_agenda=graburl($url_agenda,true,300);

$days_agenda=explode('<h3 class="V12">',$html_agenda);

$nb_days=count($days_agenda);

/*

<a name="Thursday, November 21"></a><h3 class="V12">Thursday, November 21</h3><div class="V13">

<h4>MILONGA: Schouwburg @ Kortrijk</h4>

<img width="16" height="16" src="http://agenda.milonga.be/images/time.gif" alt="When">&nbsp;8:00 PM - 11:30 PM<br />

<img width="16" height="16" src="http://agenda.milonga.be/images/house.gif" alt="Where">&nbsp;Balletzaal Schouwburg Kortrijk - Hazelaarsstraat 7, 8500 Kortrijk<br />

<div style="padding-left: 20px; padding-top: 4px; color: #333; font-style: italic">

volg aan het ijzeren hek de pijlen, die u naar de stemmige balletzaal leiden.<br />Goede danszaal - gezellige sfeer - iedere week een andere DJ.<br />Parquet - ambiance - autre DJ chaque semaine.<br />Good floor - nice ambiance -  other DJ every week.

</div>

*/

$eventlist="";

for($i=1;$i<$nb_days;$i++){

	$day_agenda=$days_agenda[$i];

	$the_day=substr($day_agenda,0,strpos($day_agenda,"<"));

	$events_day=explode('<div class="V13">',$day_agenda);

	$nb_events=count($events_day);

	$eventlist.="\n== $the_day\r\n";

	for($j=0;$j<$nb_events;$j++){

		$event_html=$events_day[$j];

		$the_title=gettagfromhtml($event_html,"h4",false);

		if($the_title){

			$txt=txt_removehtml($event_html);

			$txt=str_replace("&nbsp;"," ",$txt);

			$txt=preg_replace("#\n\s\s*#","\n",$txt);

			$lines=explode("\n",$txt);

			$the_time=trim($lines[2]);

			$the_time=trim(substr($the_time,0,strpos($the_time,"-")));

			$the_place=trim($lines[3]);

			$the_descr=trim($lines[5]);

			$eventlist.="* $the_time : $the_title\r\n";

			$event_html=strtolower($event_html);

			preg_match_all("#mailto:([a-z0-9\.\-\_]*@[a-z0-9\.\_\-]*)#",$event_html,$matches1,PREG_SET_ORDER);

			preg_match_all("#\s([a-z0-9\.\-\_]*[a-z]@[a-z][a-z0-9\.\_\-]*)\s#",$event_html,$matches2,PREG_SET_ORDER);

			if($matches1){

				foreach($matches1 as $match){

					$email=$match[1];

					if(strlen($email)>5)	$emailfound[$email]=$email;

				}

			}

			if($matches2){

				foreach($matches1 as $match){

					$email=$match[1];

					if(strlen($email)>5)	$emailfound[$email]=$email;

				}

			}

		}

	}



}

$content=file_get_contents("config/alert.txt");

$content=str_replace("{EVENTS}",$eventlist,$content);

// $emailfound["peter.forret@gmail.com"]="peter.forret@gmail.com";

sort($emailfound);

$emaillist=implode(", ",$emailfound);



$mail_from="Milonga.be events <milonga@milonga.be>";

$mail_subject="Please check your milonga.be events for the next weeks";

$mail_destination="milonga@milonga.be";

$mail_bcc=$emaillist;

echo "<form method='get'>\n";

echo "<dt>From:</dt><dd>".htmlspecialchars($mail_from)."</dd>\n";

echo "<dt>To: (" . count($emailfound) . ")</dt><dd><textarea name='' style='width: 800px; height: 75px; font-size:.9em' />$emaillist</textarea></dd>\n";

echo "<dt>Subject:</dt><dd><b>$mail_subject</b></dd>\n";

echo "<dt>Text:</dt><dd><textarea name='' style='width: 800px; height: 600px; font-size: .9em' >$content</textarea></dd>\n";

if($confirm){

	$headers = "From: $mail_from\r\n";

	$headers .= "Bcc: $mail_bcc\r\n";

	$sent=mail($mail_destination,$mail_subject,$content,$headers);

	if($sent){

		echo "<dt>Confirm:</dt><dd>Sent! $sent</dd>\n";

	} else {

		echo "<dt>Confirm:</dt><dd>Error!</dd>\n";

	}

} else {

	echo "<dt>Confirm:</dt><dd><input type='submit' name='confirm' value='Send mail!'/></dd>\n";

}

echo "</form>";





tmpl_footer();

?>
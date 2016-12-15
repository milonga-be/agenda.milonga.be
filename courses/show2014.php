<?php
include_once("../../lib/template.inc");
include_once("../../lib/class_readini.inc");
include_once("legend.php");
tmpl_setbase("embed");
tmpl_header("Tango classes in Belgium - www.milonga.be");

$ini=New ReadIni("courses2014.ini");
$lg=New Legend;

$pc_first=getparam("from");
$pc_last=getparam("to");
$postcode=getparam("postcode");
if($postcode){
	$pc_first=$postcode;
	$pc_last=$postcode;
}
$only_level=getparam("level");
$only_day=getparam("day");
$only_school=getparam("school");
$code=getparam("code");
$lang=getparam("lang","en");
$special=getparam("special",false);
switch(true){
case $special == "emails":
	$emails=Array();
	$codes=$ini->listsegments();
	foreach($codes as $code){
		$email=strtolower($ini->get("email",$code));
		if($email)	$emails[$email]=$email;
	}
	sort($emails);
	echo "<code>" . implode(", ",$emails) . "</code>";
	break;
case $code:
	school_header($code);
	school_courses($code);
	break;
case $only_school:
	$codes=$ini->listsegments();
	foreach($codes as $code){
		if(contains($code,$only_school)){
		school_header($code);
		school_courses($code);
		}
	}
	break;
case strlen($only_level)>0:
	$codes=$ini->listsegments();
	foreach($codes as $code){
		if(check_courses($code,$only_level)){
		school_header($code,true);
		school_courses($code,$only_level);
		}
	}
	break;
case $only_day:
	$codes=$ini->listsegments();
	foreach($codes as $code){
		if(check_courses($code,false,$only_day)){
		school_header($code,true);
		school_courses($code,false,$only_day);
		}
	}
	break;
case $pc_first:
	$codes=$ini->listsegments();
	sort($codes);
	foreach($codes as $code){
		list($pc,$school1,$school2)=explode(".",$code);
		$pc=(int)$pc;
		if($pc_first <= $pc AND $pc <= $pc_last){
		school_header($code,true);
		school_courses($code,false,$only_day);
		}
	}
	break;
default:
	$codes=$ini->listsegments();
	sort($codes);
	foreach($codes as $code){
		school_header($code,true);
	}
}

tmpl_footer();

function school_header($code,$short=false){
	global $ini;
	global $lg;
	
	$name=$ini->get("name",$code);
	if(!$name)	return false;
	$venue=$ini->get("venue",$code);
	$addr=$ini->get("address",$code);
	$pc=$ini->get("postcode",$code);
	$phone=$ini->get("phone",$code);
	$email=$ini->get("email",$code);
	$murl=$ini->get("milonga_url",$code);
	$eurl=$ini->get("external_url",$code);
	$furl=$ini->get("facebook_url",$code);
	$courses=$ini->get("course",$code);
	if($courses){
		$nbcourses="<code>[" . count($courses) . "]</code>";
		} else {
		$nbcourses="";
		}
	
	if($short){
		if(!$courses)	return false;
		if($venue)
			echo "<div style='border-top: #666 solid 1px'>$nbcourses <a href='?code=$code'><b>$pc: $name</b></a> <small>$venue</small></div>";
		else
			echo "<div style='border-top: #666 solid 1px'>$nbcourses <a href='?code=$code'><b>$pc: $name</b></a> <small>$addr</small></div>";
	} else {
		echo "<div style='background: #DDD; margin-top: 8px; padding: 4px'>";
		echo "<a href='?code=$code'><b>$name</b></a><br />";
		if($venue)	echo "<img src='http://www.forret.com/icons/fugue/icons/building-old.png' />$venue<br />";
		echo "<img src='http://www.forret.com/icons/fugue/icons/home.png'> $addr<br />";
		if($phone)	echo "<img src='http://www.forret.com/icons/fugue/icons/mobile-phone-off.png' /> $phone<br />";
		if($email)	echo "<img src='http://www.forret.com/icons/fugue/icons/mail.png' /> <a href='mailto:$email'>$email</a><br />";
		//if($murl)	echo "<img src='http://www.forret.com/icons/fugue/icons/book-open-text-image.png' /> <a href='$murl'>$name</a><br />";
		if($eurl)	echo "<img src='http://www.forret.com/icons/fugue/icons/book-open-next.png' /> <a target='_blank' href='$eurl'>" . parse_url($eurl,PHP_URL_HOST) . "</a><br />";
		if($furl)	echo "<img src='http://www.forret.com/icons/fugue/icons/book-open-next.png' /> <a target='_blank' href='$furl'>Facebook</a><br />";
		echo "</div>";
	}

}

function school_courses($code,$only_level=false,$only_day=false){
	global $ini;
	global $lg;
	
	$courses=$ini->get("course",$code);
	if(!$courses)	return false;
	echo "<table cellpadding=3 cellspacing=0 border=0>";
	foreach($courses as $num => $course){
		list($day,$hour,$level,$teachers) = explode(";",$course,4);
		if($only_day AND $only_day <> $day)	continue;
		if($only_level AND $only_level <> $level)	continue;
		echo "<tr>";
		echo "<td><img src='http://www.forret.com/icons/fugue/icons/calendar-select-days.png' height='10'/></td>";
		
		echo "<td>" . $lg->get($day,"day") . "</td>";
		echo "<td>" . $hour . "</td>";
		echo "<td>" . $lg->get($level,"level") . "</td>";
		echo "<td>" . $teachers . "</td>";
		echo "</tr>\n";
	}
	echo "</table>";
}

function check_courses($code,$only_level=false,$only_day=false){
	global $ini;
	global $lg;
	
	$courses=$ini->get("course",$code);
	if(!$courses)	return false;
	$found=false;
	foreach($courses as $num => $course){
		list($day,$hour,$level,$teachers) = explode(";",$course,4);
		if($only_day AND $only_day <> $day)	continue;
		if($only_level AND $only_level <> $level)	continue;
		$found=true;
		}
	return $found;
	}

?>


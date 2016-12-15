<?php
include_once("../../lib/template.inc");
include_once("../../lib/class_readini.inc");
include_once("legend.php");
tmpl_setbase("embed");

$ini=New ReadIni("courses2016sep.ini");
$lg=New Legend;

$pc_first=getparam("from");
$pc_last=getparam("to");
$additional=getparam("additional");
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

switch(true){
case $code:
    tmpl_header("Tango classes in Belgium - www.milonga.be");
	school_header($code);
	school_courses($code);
    echo "<div style='text-align: center; font-size: .9em; padding: 6px'><a href='http://agenda.milonga.be/courses/'>View all classes</a></div>";
	break;
case $only_school:
    tmpl_header("Tango classes in Belgium - www.milonga.be");
	$codes=$ini->listsegments();
	sort($codes);
	foreach($codes as $code){
		if(contains(strtolower($code),strtolower($only_school))){
		school_header($code);
		school_courses($code);
		}
	}
	break;
case strlen($only_level)>0:
    tmpl_header("Tango classes of level $only_level - www.milonga.be");
	$codes=$ini->listsegments();
	sort($codes);
	foreach($codes as $code){
		if(check_courses($code,$only_level)){
		school_header($code,true);
		school_courses($code,$only_level);
		}
	}
	break;
case $only_day:
    tmpl_header("Tango classes on $only_day - www.milonga.be");
	$codes=$ini->listsegments();
	sort($codes);
	foreach($codes as $code){
		if(check_courses($code,false,$only_day)){
		school_header($code,true);
		school_courses($code,false,$only_day);
		}
	}
	break;
case $pc_first:
    tmpl_header("Tango classes in $pc_first - www.milonga.be");
	$codes=$ini->listsegments();
	sort($codes);
	$additional_codes = explode(',',$additional);
	foreach($codes as $code){
		list($pc,$school1,$school2)=explode(".",$code);
		$pc=(int)$pc;
		if(($pc_first <= $pc AND $pc <= $pc_last) || in_array($pc,$additional_codes)){
		school_header($code,true);
		school_courses($code,false,$only_day);
		}
	}
	break;
default:
    tmpl_header("Tango classes in Belgium - www.milonga.be");
	$codes=$ini->listsegments();
	if($codes){
		sort($codes);
		foreach($codes as $code){
			school_header($code,true);
		}
	} else{
		echo "<p>Waiting for new updated info</p>";
	}
}


tmpl_footer();

function school_header($code,$short=false){
	global $ini;
	global $lg;
	global $tot_courses;
	global $tot_schools;
	
	$name=$ini->get("name",$code);
	if(!$name)	return false;
	$venue=$ini->get("venue",$code);
	$addr=$ini->get("address",$code);
	$pc=$ini->get("postcode",$code);
	$phone=$ini->get("phone",$code);
	$email=$ini->get("email",$code);
	$murl=$ini->get("milonga_url",$code);
	$eurl=$ini->get("external_url",$code);
	if($eurl AND !substr($eurl,0,4) == "http")	$eurl="http://$eurl";
	$furl=$ini->get("facebook_url",$code);
	if($furl AND !substr($furl,0,4) == "http")	$furl="https://$furl";
	$courses=$ini->get("course",$code);
	if($courses){
		$nbcourses="<code>[" . count($courses) . "]</code>";
		$tot_courses+=count($courses);
		$tot_schools++;
	} else {
		$nbcourses="";
	}
	
	if($short){
		if(!$courses)	return false;
		echo "<div><a xhref='?postcode=$pc' title='All courses in $pc'>$pc</a>: <a href='?code=$code' title='$name - $venue $addr'><b>$name</b></a> <small>$venue</small> $nbcourses</div>\n";
	} else {
		echo "<div style='background: #DDD; margin-top: 8px; padding: 4px'; text-align: left>";
		echo "<a href='?code=$code'><b>$name</b></a><br />";
		if($venue)	echo "<img height='16' src='http://toolstud.io/icon/flaticon/home149.png' /> $venue<br />";
		echo "<img height='16' src='http://toolstud.io/icon/flaticon/address20.png'> $addr<br />";
		if($phone)	echo "<img height='16' src='http://toolstud.io/icon/flaticon/phone370.png' /> $phone<br />\n";
		if($email)	echo "<img height='16' src='http://toolstud.io/icon/flaticon/email108.png' /> <a href='mailto:$email'>$email</a><br />\n";
		//if($murl)	echo "<img height='16' src='http://www.forret.com/icons/fugue/icons/book-open-text-image.png' /> <a href='$murl'>$name</a><br />";
		if($eurl)	echo "<img height='16' src='http://toolstud.io/icon/flaticon/links9.png' /> <a target='_blank' href='$eurl'>" . parse_url($eurl,PHP_URL_HOST) . "</a><br />\n";
		if($furl)	echo "<img height='16' src='http://toolstud.io/icon/brands/facebook18.png	' /> <a target='_blank' href='$furl'>" . basename($furl) . "</a><br />\n";
		echo "</div>\n";
	}

}

function school_courses($code,$only_level=false,$only_day=false){
	global $ini;
	global $lg;
	
	$courses=$ini->get("course",$code);
	if(!$courses)	return false;
	sort($courses);
	echo "<table cellpadding=3 cellspacing=0 border=0>";
	foreach($courses as $num => $course){
		list($day,$hour,$level,$teachers) = explode(";",$course,4);
		if($only_day AND $only_day <> $day)	continue;
		if(strlen($only_level)>0 AND $only_level <> $level)	continue;
		echo "<tr>";
		echo "<td><img height='16' src='http://toolstud.io/icon/flaticon/clock100.png' height='10'/></td>";
		
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
		if($only_level <> $level)	continue;
		$found=true;
		}
	return $found;
	}

?>


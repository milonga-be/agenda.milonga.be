<?php
include_once("../../lib/template.inc");
//$debug=true;

header("Content-Type: text/plain");
$datafile="courses.xml";
if (file_exists($datafile)) {
	$xml = simplexml_load_file($datafile);

	$courses=$xml->course;
	foreach($courses as $course){
		$postcode=(int)$course['postcode'];
		$level=(int)$course['level'];
		$school=utf8_decode((string)$course['school']);
		$address=utf8_decode((string)$course['address']);
		$day=(int)$course['time_day'];
		$url=(string)$course['school_uri'];
		$hour=(string)$course['time_hour'];
		$teachers=utf8_decode((string)$course['teachers']);
		$teachers2=substr(txt_makecanonical($teachers,Array("+")),0,3);
		$show_course=true;
		$school2=txt_makecanonical($school,Array("asbl","vzw","le","la","dansschool"));
		$schoolcode=substr("$postcode.$school2",0,25);
		$coursecode="$day.$hour.$level.$teachers2";
		$schools[$schoolcode]["data"]["postcode"]=$postcode;
		$schools[$schoolcode]["data"]["name"]=$school;
		$schools[$schoolcode]["data"]["address"]=$address;
		$schools[$schoolcode]["data"]["url"]=$url;
		
		$schools[$schoolcode]["courses"]["$coursecode"]["day"]=$day;
		$schools[$schoolcode]["courses"]["$coursecode"]["hour"]=$hour;
		$schools[$schoolcode]["courses"]["$coursecode"]["level"]=$level;
		$schools[$schoolcode]["courses"]["$coursecode"]["teachers"]=$teachers;
	}
	ksort($schools);
	foreach($schools as $scode => $data){
		ini_title($scode);
		foreach($data["data"] as $key => $val){
			ini_line($key,$val);
		}
		ksort($data["courses"]);
		foreach($data["courses"] as $ccode => $details){
			ini_line("course[]",implode(";",$details));
		}
	}

} else {
	echo "ERROR: could not read [$datafile]";
}

function ini_title($key){
	echo "\n[$key]\n";
}

function ini_line($key,$val){
	switch(true){
	case is_int($val):	echo "$key= $val\n";	break;
	default:	echo "$key= \"$val\"\n";	break;
	}
}
?>


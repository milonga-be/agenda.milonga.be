<?php
//header("Content-Type: text/plain");
include_once("../../tools.forret.com/lib/tools.inc");
$debug=false;
$pc_first=getparam("from",1000);
$pc_last=getparam("to",9999);
$only_level=getparam("level","");
$only_day=getparam("day",-1);
$only_school=strtolower(getparam("school",""));
$lang=getparam("lang","en");

$prev_pc=0;
$prev_sch="";
switch($lang){
	case "fr":
			$days=Array(
			1 => "lundi",
			2 => "mardi",
			3 => "mercredi",
			4 => "jeudi",
			5 => "vendredi",
			6 => "samedi",
			7 => "dimanche"
			);
		$levels=Array(
			"0" => "Débutants absolus (pas d'expérience)",
			"1" => "Débutants (&lt; 1 an)",
			"2" => "Intermédiaire (1-2 ans)",
			"3" => "Intermédiaires avancés (2-3 ans)",
			"4" => "Avancés (3-5 ans))",
			"5" => "Experts (&gt;5 ans)",
			"P" => "Practica (pour élèves)"
			);
		$n_pc="Code postal";
		$n_sch="Ecole";
		break;

	case "nl":
		$days=Array(
			1 => "maandag",
			2 => "dinsdag",
			3 => "woensdag",
			4 => "donderdag",
			5 => "vrijdag",
			6 => "zaterdag",
			7 => "zondag"
			);
		$levels=Array(
			"0" => "Absolute beginners (geen ervaring)",
			"1" => "Beginners (&lt;1j)",
			"2" => "Intermediate (1-2j)",
			"3" => "Medium Advanced (2-3j)",
			"4" => "Gevorderd (3-5j)",
			"5" => "Experts (&gt;5j)",
			"P" => "Practica (voor leerlingen)"
			);
		$n_pc="Postcode";
		$n_sch="School";
		break;

	default:
		$days=Array(
			1 => "Monday",
			2 => "Tuesday",
			3 => "Wednesday",
			4 => "Thursday",
			5 => "Friday",
			6 => "Saturday",
			7 => "Sunday"
			);
		$levels=Array(
			"0" => "Absolute beginners (no experience)",
			"1" => "Beginners (&lt;1y)",
			"2" => "Intermediate (1-2y)",
			"3" => "Medium Advanced (2-3y)",
			"4" => "Advanced (3-5y)",
			"5" => "Experts (&gt;5y)",
			"P" => "Practica (for pupils)"
			);
		$n_pc="Postcode";
		$n_sch="School";
}

$datafile="courses.xml";
$sel_courses=Array();

if (file_exists($datafile)) {
	$xml = simplexml_load_file($datafile);

	$courses=$xml->course;

	foreach($courses as $course){
		$postcode=(int)$course['postcode'];
		$level=$course['level'];
		$school=strtolower($course['school']);
		$day=(int)$course['time_day'];
		$show_course=true;
		if($postcode < $pc_first) $show_course=false;
		if($postcode > $pc_last) $show_course=false;
		if($only_level AND $level != $only_level) $show_course=false;
		if($only_day   >= 0 AND $day != $only_day) $show_course=false;
		if($only_school     AND strpos($school,$only_school) === false) $show_course=false;

		if($show_course) add_course($course);
	}
	ksort($sel_courses);
	foreach($sel_courses as $selkey => $seldata){
		show_course($seldata);
	}

} else {
	echo "ERROR: could not read [$datafile]";
}

function add_course($course){
	global $sel_courses;
	
	$key=$course['postcode'].$course['school'].$course['time_day'].$course['time_hour'].$course['level'].$course['teachers'];
	$sel_courses[$key]=$course;
}

function show_course($course){
	global $days, $levels, $prev_pc, $prev_sch, $n_pc, $n_sch;
	//print_r($course);
	$school_pc=$course['postcode'];
	$school_name=$course['school'];
	$school_url=$course['school_uri'];
	$school_adr=$course['address'];

	$course_level=$course['level'];
	$course_level=$levels["$course_level"];
	$course_teachers=$course['teachers'];

	$course_day=(int)$course['time_day'];
	$course_day=$days[$course_day];

	$course_time=$course['time_hour'];
	
	echo implode(";",Array($school_pc,$school_name,$school_adr,$course_level,$course_teachers,$course_day)) . "\n";



}
?>

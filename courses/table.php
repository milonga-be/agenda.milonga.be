<?php
include_once("../../tools.forret.com/lib/tools.inc");
//$debug=true;
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<HEAD>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.milonga.be/wp-content/themes/k2/style.css" />
<link rel="stylesheet" type="text/css" href="http://www.milonga.be/wp-content/themes/k2/styles/sample/sample.css" />
<style>
h4 {
	font-size: 14px;
	border-top: 1px #900 solid;
	margin-top: 8px;
	margin-bottom: 4px;
	color: #900;
}
</style>
<TITLE>Milonga.be Courses</TITLE>
</HEAD>

<BODY>
<div id="page">
<?php
$datafile="courses.xml";
if (file_exists($datafile)) {
	$xml = simplexml_load_file($datafile);

	$courses=$xml->course;
	echo "<table style='font-size: .8em' cellpadding=0 cellspacing=2>";

	foreach($courses as $course){
		$postcode=(int)$course['postcode'];
		$level=$course['level'];
		$school=strtolower($course['school']);
		$day=(int)$course['time_day'];
		$show_course=true;
		show_course($course);
	}
	echo "</table>";

} else {
	echo "ERROR: could not read [$datafile]";
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

	$course_teachers=str_replace(" + "," &amp; ",$course_teachers);
	echo "<tr><td>$school_pc</td><td>$school_name</td></tr>\n";

}
?>


</div>
</BODY>
</HTML>

<?php
include_once("../lib/tools.inc");
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

$datafile="courses/courses.xml";
if (file_exists($datafile)) {
	$xml = simplexml_load_file($datafile);

	$courses=$xml->course;
	$total=0;
	$count=Array();
	foreach($courses as $course){
		$postcode=(int)$course['postcode'];
		$level=$course['level'];
		$count["$level"]+=1;
		$total++;
	}
	echo "Check out the <a href='http://www.milonga.be/classes/'><b>$total</b> classes all over Belgium</a><br /><small>";
	$i=0;
	foreach($levels as $level => $name){
		$i++;
		$nb=$count[$level];
		if($i % 2){
			echo "$name : <code>$nb</code> || ";
		} else {
			echo "$name : <code>$nb</code><br />";
		}
	}
	echo "</small>";
} else {
	echo "ERROR: could not read [$datafile]";
}

?>

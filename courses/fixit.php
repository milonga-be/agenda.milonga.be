<?php
include_once("../../lib/template.inc");
include_once("../../lib/class_readini.inc");
include_once("legend.php");
tmpl_setbase("embed");
tmpl_header("Tango classes formatter");
$input=$_POST["input"];
echo "<form method='post'><fieldset><legend>Input</legend>";
echo "<textarea name='input' style='font-family: Courier; font-size: 10px; width: 600px; height:250px'>$input</textarea><br />";
echo "<input type=submit value='Reformat'>";
echo "</fieldset></form>";
echo "<fieldset><legend>Formatted</legend>";
$debug=true;
if($input){
	// read values
	$lines=explode("\n",$input);
	foreach($lines as $line){
		if(contains($line,":")){
			list($key,$val)=explode(":",$line,2);
			$value[$key]=trim($val);
		}
	}
	// guess which errors, if any
	switch(true){
	case is_pc($value["Postcode"]) AND is_level($value["Level"]) AND is_day($value["Weekday"]):
		$postcode=$value["Postcode"];
		$city=$value["City"];
		$teachers=$value["Teachers"];
		$level=$value["Level"];
		$weekday=$value["Weekday"];
		$hour=$value["Hour"];
		$course="$weekday;$hour;$level;$teachers";
		break;
	case is_pc($value["Address"]) AND is_level($value["City"]) AND is_day($value["Teachers"]):
		$postcode=$value["Address"];
		$city=$value["Postcode"];
		$teachers=$value["Hour"];
		$level=$value["City"];
		$weekday=$value["Teachers"];
		$hour=$value["Level"];
		$course="$weekday;$hour;$level;$teachers";
		break;
	case is_hour($value["Weekday"]) AND is_level($value["City"]) AND is_day($value["Level"]):
		$postcode=$value["Address"];
		$city=$value["Postcode"];
		$teachers=$value["First"];
		$level=$value["City"];
		$weekday=$value["Level"];
		$hour=$value["Weekday"];
		$course="$weekday;$hour;$level;$teachers";
		break;
	default:
		echo "<pre>";
		print_r($value);
		echo "</pre>";
	}
}
$output="course[]= \"$course\"";
echo "<pre>$output</pre><br />";

echo "</fieldset>";

$lab=New Legend;
function is_pc($text){
	$numpc=(int)$text;
	if($numpc >=1000 AND $numpc <=9999){
		trace("is_pc: [$text] could be postcode");
		return true;
	} else{
		trace("is_pc: [$text] is not postcode");
		return false;
	};
}
function is_level($text){

	if(contains("012345AP",$text)){
		trace("is_level: [$text] could be level");
		return true;
	} else{
		trace("is_level: [$text] is not level");
		return false;
	};
}

function is_day($text){
	global $lab;
	if(contains("1234567",$text)){
		trace("is_day: [$text] could be day");
		return true;
	} else{
		trace("is_day: [$text] is not day");
		return false;
	};
}
function is_hour($text){
	list($hour,$min)=explode(":",$text,2);
	if(strlen($hour) < 3 AND strlen($min)==2){
		trace("is_hour: [$text] could be hh:mm");
		return true;
	} else{
		trace("is_hour: [$text] is not time");
		return false;
	};
}
function is_teacher($text){
	if(strlen($text) >= 3){
		trace("is_teacher: [$text] could be teachers");
		return true;
	} else{
		trace("is_teacher: [$text] is not teachers");
		return false;
	};
}

tmpl_footer();

?>


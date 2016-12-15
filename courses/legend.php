<?php

Class Legend{
	var $labels=Array();
	
	function __construct(){
		$this->labels["level"] = Array(
			"fr" => Array(
				"0" => "Débutants absolus",
				"1" => "Débutants (&lt; 1 an)",
				"2" => "Intermédiaire (1-2 ans)",
				"3" => "Intermédiaires avancés (2-3 ans)",
				"4" => "Avancés (3-5 ans)",
				"5" => "Experts (&gt;5 ans)",
				"A" => "Tous niveaux",
				"P" => "Practica (pour élèves)",
				"T" => "Cours de technique",
				),
			"nl" => Array(
				"0" => "Absolute beginners",
				"1" => "Beginners (&lt;1j)",
				"2" => "Intermediate (1-2j)",
				"3" => "Medium Advanced (2-3j)",
				"4" => "Gevorderd (3-5j)",
				"5" => "Experts (&gt;5j)",
				"A" => "Alle niveaus",
				"P" => "Practica (voor leerlingen)",
				"T" => "Techniek",
				),
			"en" => Array(
				"0" => "Absolute beginners",
				"1" => "Beginners (&lt;1y)",
				"2" => "Intermediate (1-2y)",
				"3" => "Medium Advanced (2-3y)",
				"4" => "Advanced (3-5y)",
				"5" => "Experts (&gt;5y)",
				"A" => "All levels",
				"P" => "Practica (for pupils)",
				"T" => "Tango Technique"
				)
			);
		$this->labels["day"] = Array(
			"fr" => Array(
				1 => "lundi",
				2 => "mardi",
				3 => "mercredi",
				4 => "jeudi",
				5 => "vendredi",
				6 => "samedi",
				7 => "dimanche"
				),
			"nl" => Array(
				1 => "maandag",
				2 => "dinsdag",
				3 => "woensdag",
				4 => "donderdag",
				5 => "vrijdag",
				6 => "zaterdag",
				7 => "zondag"
				),
			"en" => Array(
				1 => "Monday",
				2 => "Tuesday",
				3 => "Wednesday",
				4 => "Thursday",
				5 => "Friday",
				6 => "Saturday",
				7 => "Sunday"
				)
			);
		$this->labels["text"]=Array(
			"nl" => Array(
				"postcode" 	=> "Postcode",
				"level" 	=> "Niveau",
				"day" 	=> "Dag",
				"school"	=> "School",
				"address"	=> "Adres",
				),
			"fr" => Array(
				"postcode" 	=> "Code postal",
				"level" 	=> "Nveau",
				"day" 	=> "Journée",
				"school"	=> "Ecole",
				"address"	=> "Adresse",
				),
			"en" => Array(
				"postcode" 	=> "Postcode",
				"level" 	=> "Level",
				"day" 	=> "Day",
				"school"	=> "School",
				"address"	=> "Address",
				),
			);
	}

	function get($key,$type="text",$lang=false){
		if(!$lang)	$lang=getparam("lang","en");
		if(isset($this->labels[$type][$lang][$key]))
			return $this->labels[$type][$lang][$key];
		else
			return $key;
	}



}
?>
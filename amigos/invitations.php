<?php

include_once("../../lib/template.inc");

include_once("../../lib/class_gdoc.inc");

$gd=New Gdoc();

tmpl_setbase("_template");

tmpl_header("Amigos: Invitations");

$thisuniq=getparam("uniq");

$lang=getparam("lang","en");

$debug=true;

$persons=$gd->GDocCSV("https://docs.google.com/spreadsheet/pub?key=0Av7twOSrHkTddDQ5X1Q0MjdFaW9haFAtc2RaamdJLVE&single=true&gid=0&output=csv");

//trace($persons);

$nbvip=0;

foreach($persons as $person){

	$uniq=substr(md5($person["email"]),0,10);

/*

    [7] => Array

        (

            [id] => 609

            [email] => eleni.constantinidou@gmail.com

            [entered] => 2/17/2010 12:49:17

            [last_modified] => 2/17/2010 14:32:40

            [send_this_user_html_emails] => 1

            [which_page_was_used_to_subscribe] => 1

            [country] => Belgium

            [first_name] => Eleni

            [last_name] => Constantinidou

            [vip] => 1

            [postcode] => 1000-1210 (Brussels)

            [gender] => Female

            [list_membership] => Milonga Agenda Brussels Tango Festival

        )



)*/

	if(!$person["vip"])	continue;

	$nbvip++;

	echo "[";

	$maillang=strtolower($person["lang"]);

	if(!$maillang)	$maillang="en";

	echo "<a href='?uniq=$uniq&lang=$maillang'>$person[first_name] $person[last_name] ($maillang)</a> ";

	echo "] ";

	if($uniq==$thisuniq){

		$smarty->assign('fname',$person["first_name"]);

		$name=$person["first_name"] . " " . $person["last_name"];

		//print_r($smarty);

		$body=$smarty->fetch("invitation.$lang.tpl");

		$body=urlencode($body);

		switch($lang){

		case "en":

			$title=urlencode("Tango workshops with Cecilia Piccinni & Andres Molina in Brussels");

			break;

		case "fr":

			$title=urlencode("Workshops de tango avec Cecilia Piccinni & Andres Molina à Bruxelles");

			break;

		default:

			$title=urlencode("Tango workshops met Cecilia Piccinni & Andres Molina in Brussel");

		}

		echo "<p><a target='_blank' href='mailto:&quot;$name&quot; &lt;$person[email]&gt;?subject=$title'>SEND!</a>";

		echo "<textarea style='width: 100%; height: 200px; font-family: Verdana; font-size: 10px;'>";

		$smarty->display("invitation.$lang.tpl");

		echo "</textarea></p>";



	}

}

echo "<b>$nbvip persons</b>";



tmpl_footer();



function get_firstname($name){

	$words=explode(" ",$name);

	switch(count($words)){

		case 1:

			return $name;

			break;

		case 2:

			return $words[0];

			break;

		default:

			return $name;

	}

}

?>




<?php

include_once("../../lib/template.inc");

include_once("../../lib/class_gdoc.inc");

$gd=New Gdoc();

tmpl_setbase("_template");

tmpl_header("Amigos: Registrations");

$thisuniq=getparam("uniq");

$lang=getparam("lang","en");

$debug=true;

$regs=$gd->GDocCSV("https://docs.google.com/spreadsheet/pub?key=0Av7twOSrHkTddEUxS0pGR213bERmUlczMmdZTFRkc0E&single=true&gid=0&output=csv");

trace($regs);

foreach($regs as $reg){

	$uniq=substr(md5($reg["leader_email"].$reg["timestamp"]),0,10);

/*

Array

(

    [timestamp] => 9/27/2013 18:16:19

    [leader_name] => Sven Breynaert

    [leader_email] => sonjaysven@gmail.com

    [follower_name] => Sonja Bruyninckx

    [follower_email] => sonjaysven@gmail.com

    [phone_number] => 0497 454 677

    [sat/sam_5_oct_-_14:00] => Yes

    [sat/sam_5_oct_-_15:30] => Yes

    [sun/dim_6_oct_-__14:00] => Yes

    [sun/dim_6_oct_-_15:30] => Yes

    [how_did_you_hear_about_these_workshops?] => A friend told me

    [if_you_have_remarks_/_si_vous_avez_des_remarques_] => We take the 4 ws package! :-)

Good luck, guys!

xxx

)*/

	echo "<li>";

	echo "<a href='?uniq=$uniq&lang=$lang'>$reg[leader_name] + $reg[follower_name]</a> - ";

	$nbws=0;

	if($reg["fri/ven_4_oct_-_19:30"])	$nbws++;

	if($reg["sat/sam_5_oct_-_14:00"])	$nbws++;

	if($reg["sat/sam_5_oct_-_15:30"])	$nbws++;

	if($reg["sat/sam_5_oct_-_17:00"])	$nbws++;

	if($reg["sun/dim_6_oct_-__14:00"])	$nbws++;

	if($reg["sun/dim_6_oct_-_15:30"])	$nbws++;

	switch(true){

	case $nbws<4;

		$price=$nbws*20;

		break;

	case $nbws<6:

		$price=4*15+($nbws-4)*20;

		break;

	case $nbws==6:

		$price=85;

	}

	$price=$price;

	echo "$nbws WS - $price &euro;/person ";

	if($reg["how_did_you_hear_about_these_workshops?"]){

		echo " <small><i>" . $reg["how_did_you_hear_about_these_workshops?"] . "</i></small>";

	}

	$remarks=$reg["if_you_have_remarks_/_si_vous_avez_des_remarques_"];

	if($remarks){

		echo "<pre>$remarks</pre>";

	}	

	echo "</li>";

	if($uniq==$thisuniq){

		$fname1=get_firstname($reg["leader_name"]);

		$fname2=get_firstname($reg["follower_name"]);

		$smarty->assign('email1',$reg["leader_email"]);

		$smarty->assign('email2',$reg["follower_email"]);

		$smarty->assign('fname1',$fname1);

		$smarty->assign('fname2',$fname2);

		$smarty->assign('price',$price);

		$smarty->assign('nb_workshops',$nbws);

		//print_r($smarty);

		$body=$smarty->fetch("reg_mail.$lang.tpl");

		$body=urlencode($body);

		$title=urlencode("Your registration for Cecilia y Andres this weekend");

		echo "<a target='_blank' href='mailto:&quot;$fname1&quot; &lt;$reg[leader_email]&gt;,&quot;$fname2&quot; &lt;$reg[follower_email]&gt;?subject=$title&body=$body'>Reply!</a>";

		echo "<textarea style='width: 100%; height: 500px;'>";

		$smarty->display("reg_mail.$lang.tpl");

		echo "</textarea>";



	}

	$toteuro+=$price;

	$totws+=$nbws;

}

$toteuro=2*$toteuro;

echo "<b>$totws workshops - $toteuro &euro;</b>";



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




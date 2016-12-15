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

	$email1=trim(strtolower($reg["leader_email"]));

	$name1=trim($reg["leader_name"]);

	$email2=trim(strtolower($reg["follower_email"]));

	$name2=trim($reg["follower_name"]);

	if($email1) $emails[$email1]=$name1;

	if($email2) $emails[$email2]=$name2;

}

$emails["maria_2004_84@hotmail.com"]="maria_2004_84@hotmail.com";

$emails["enr.nieto@gmail.com"]="enr.nieto@gmail.com";

$emails["catinarg@gmail.com"]="catinarg@gmail.com";

$emails["p_d_m_a@hotmail.com"]="p_d_m_a@hotmail.com";

$emails["belenrohuet@gmail.com"]="belenrohuet@gmail.com";

$emails["mary_marenco@hotmail.com"]="mary_marenco@hotmail.com";

$emails["nuray.dogru@gmail.com"]="nuray.dogru@gmail.com";





ksort($emails);

foreach($emails as $email => $name){

echo "&quot;$name&quot; &lt;$email&gt;,<br />";

}



tmpl_footer();



?>




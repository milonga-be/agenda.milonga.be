<?php
include_once("../../lib/template.inc");
include_once("../../lib/class_readini.inc");
include_once("../../lib/class_mutt.inc");

include_once("legend.php");
tmpl_setbase("embed");
$debug=true;
$confirm=getparam("confirm");

$ini=New ReadIni("courses2016sep.ini");
$lg=New Legend;

$pc_first=getparam("from");
$pc_last=getparam("to");
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


tmpl_header("Tango classes - send mail to teachers");
$codes=$ini->listsegments();
if($codes){
	sort($codes);
	foreach($codes as $code){
		$email=$ini->get("email",$code);
		if($email){
			$emailfound[$email]=$email;
		}
	}
} else{
	echo "<p>Waiting for new updated info</p>";
}

$content=file_get_contents("alert.txt");
$year=date("Y");
$content=str_replace("{YEAR}",$year,$content);
$emailfound["milonga@milonga.be"]="milonga@milonga.be";
sort($emailfound);
$emaillist=implode(", ",$emailfound);

$mail_from="Milonga.be events <milonga@milonga.be>";
$mail_subject="Please add your $year tango courses to the milonga.be database";
$mail_destination="milonga@milonga.be";
$mail_bcc=$emaillist;
echo "<form method='get'>\n";
echo "<dt>From:</dt><dd>".htmlspecialchars($mail_from)."</dd>\n";
echo "<dt>To: (" . count($emailfound) . ")</dt><dd><textarea name='' style='width: 800px; height: 100px; font-size:.9em' />$emaillist</textarea></dd>\n";
echo "<dt>Subject:</dt><dd><b>$mail_subject</b></dd>\n";
echo "<dt>Text:</dt><dd><textarea name='' style='width: 800px; height: 600px; font-size: .9em' >$content</textarea></dd>\n";
if($confirm){
	$headers = "From: $mail_from\r\n";
	$headers .= "Bcc: $mail_bcc\r\n";
	$sent=mail($mail_destination,$mail_subject,$content,$headers);
	if($sent){
		echo "<dt>Confirm:</dt><dd>Sent! $sent</dd>\n";
	} else {
		echo "<dt>Confirm:</dt><dd>Error!</dd>\n";
	}
} else {
	echo "<dt>Confirm:</dt><dd><input type='submit' name='confirm' value='Send mail!'/></dd>\n";
}

?>


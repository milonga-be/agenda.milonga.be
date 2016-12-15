<?php

include_once("../../lib/template.inc");

include_once("../../lib/class_mutt.inc");

tmpl_setbase("_tpl");

tmpl_header("Bulk mail");



$emailfound["peter.forret@gmail.com"]="peter.forret@gmail.com";

sort($emailfound);

$emaillist=implode(", ",$emailfound);



$content=str_replace(Array("\'",'\"','\&quot;'),Array("'",'"','&quot;'),getpost("content",file_get_contents("config/template.txt")));

$mail_from="Milonga.be <peter@milonga.be>";

$mail_subject=getpost("subject","Mail from milonga.be");

$mail_to=getpost("destination","peter@milonga.be");

$emails=getpost("bcc","peter.forret@gmail.com");

$emails=str_replace(Array(",",";",":")," ",$emails);

$emails=preg_replace("#\s\s+#"," ",$emails);

$lemails=explode(" ",$emails);

$emails=implode(", ",$lemails);

$mail_bcc=$emaillist;

echo "<form method='post'>\n";

echo "<dt>From:</dt><dd>".htmlspecialchars($mail_from)."</dd>\n";

echo "<dt>To: (" . count($lemails) . ")</dt><dd><textarea name='bcc' style='width: 800px; height: 75px; font-size:.9em' />$emails</textarea></dd>\n";

echo "<dt>Subject:</dt><dd><input type=text name='subject' style='width: 800px;' value='" . htmlspecialchars($mail_subject) ."'></dd>\n";

echo "<dt>Text:</dt><dd><textarea name='content' style='width: 800px; height: 400px;' >" . htmlspecialchars($content) . "</textarea></dd>\n";



$confirm=getpost("confirm");

if($confirm){

	foreach($lemails as $email){

		$headers = "From: $mail_from\r\n";

		$headers .= "Bcc: $email\r\n";

		$sent=mail($mail_to,$mail_subject,$content .  "\n\n-- $email",$headers);

		if($sent){

			echo "<li>Confirm: $email Sent!</dd>\n";

		} else {

			echo "<li>Failed: $email!</dd>\n";

		}

	}

} else {

	echo "<dt>Confirm:</dt><dd><input type='submit' name='_nope' value='Test!'/> <input type='submit' name='confirm' value='Send mail!'/></dd>\n";

}

echo "</form>";





tmpl_footer();



function getpost($name,$default=false){

	if(isset($_POST[$name])){

		return $_POST[$name];

	} else {

		return $default;

	}

}

?>
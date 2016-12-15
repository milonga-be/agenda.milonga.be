<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset={CHARSET}" />
<title>Calendrier Tango de Belgique / Belgische tango kalender</title>
<STYLE TYPE="text/css">
a {
	color: #006;
}	
</STYLE>
</head>
<body style="font-family: Georgia, FreeSerif, Times, serif; background: #FFF">
<div style="background: #FFF; width: 1024px; padding: 6px;">

<h1 style="background-color: #000; border: 1px solid #000; color: #FFF; font-size: 24px; height: 35px; padding: 6px; text-align: center; margin: 0px;">Milonga.be weekly newsletter</h1>
<div style="font-size: .6em;">Subscribe via <a href="http://list.milonga.be">http://list.milonga.be</a></div>

<div style="font-size: .5em; color: #FFF">------------------------------------------------------------</div>
<h2 style="border: 1px solid #930; color: #930; font-size: 18px; padding: 6px;">&gt;&gt; Latest news/photos on www.milonga.be</h2>
<?php
echo file_get_contents( "http://agenda.milonga.be/milonga.php" );
?>

<div style="font-size: .5em; color: #FFF">------------------------------------------------------------</div>
<h2 style="color: #930; font-size: 18px; border: 1px solid #930; padding: 6px; ">&gt;&gt; Milonga.be tango agenda: {DISPLAY_DATE}</h2>
<p>For the most recent info: <A HREF="http://www.milonga.be/dancing/">Milonga tango agenda for Belgium</A></p>

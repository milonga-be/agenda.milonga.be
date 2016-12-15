<?php
	
define('BASE', './');
include('../global_lib/simplepie/simplepie.inc');

$feed = new SimplePie();
$feed->set_feed_url("http://tools.forret.com/parss/rss.php?c=marathons2");
$feed->init();
$feed->handle_content_type();


$template="embed";
header("Content-Type: text/html; charset=$charset");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?php echo $feed->get_title(); ?> | agenda.milonga.be - Tango in Belgium</title>
	<META NAME="Keywords" CONTENT="agenda,argentine,argentino,bal,belgie,belgien,belgique,belgium,calendar,calendrier,concert,evenement,event,kalender,milonga,salon,tango">
	<META NAME="Description" CONTENT="Tango calendar for Argentine tango in Belgium">
	<link rel="stylesheet" type="text/css" href="templates/embed/default.css" />
			
	
</head>
<body>

<center>
<table border="0" width="480" cellspacing="0" cellpadding="0">
<tr>
	<td align="left">
	<div style="text-align: right; font-size: .8em">List via <A HREF="http://tangomarathons.com/">tangomarathons.com</A></div>
	<h3 class="V12">International Tango Marathons</h3>
		<?php 
			if ($feed->data):
				$items = $feed->get_items();
				foreach($items as $item):
					$title=$item->get_title();
					$text=$item->get_content();

					?>
					<h4><a target="_blank" href="<?php echo $item->get_permalink(); ?>"><?php echo $title; ?></a></h4>
						<?php 
						echo $text;
				endforeach; ?>
		<?php endif; ?>

	</td>
	</tr>
</table>

<center class="V9">
<hr />
Tango calendar by <A HREF="http://www.milonga.be" >Milonga - Tango in Belgium</A><br />
</center>

<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=2779348; 
var sc_invisible=0; 
var sc_partition=28; 
var sc_security="739caa96"; 
</script>

<script type="text/javascript" src="http://www.statcounter.com/counter/counter_xhtml.js"></script>
<noscript>
<div class="statcounter"><a class="statcounter" href="http://www.statcounter.com/"><img class="statcounter" src="http://c29.statcounter.com/2779348/0/739caa96/0/" alt="website stats" /></a></div>
</noscript>
<!-- End of StatCounter Code -->

</body>
</html>
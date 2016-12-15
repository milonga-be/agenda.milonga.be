<?php
$day=$_GET['d'];
$url="http://agenda.milonga.be/filter.php?printview=day&getdate=$day";
header("Location: " . $url);
exit;
?>
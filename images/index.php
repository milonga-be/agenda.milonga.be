<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> Images </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>

 <BODY>

 </BODY>
<?php

$base_url = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
define("PATH",					$_SERVER["DOCUMENT_ROOT"]);	// This is the full physical root to your folder, can probably be left
$dir = PATH . $base_url;

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $full_name = "$dir$file";
			$full_url  = "$base_url$file";
            if (is_file($full_name) && substr($file,strlen($file)-4,4) == ".gif") {
                echo "<img src='$full_url' /> <a href='$full_url'>$file</a><br />";
            }
       }
       closedir($dh);
   }
}




?>
</HTML>

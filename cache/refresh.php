<?php

$afiles=scandir(".");
foreach ($afiles as $file){
	if($file!=str_replace(Array("spc","html"),'',$file)){
		echo "<p>touch $file ...</p>\n";
		touch($file,time()-3600*8);
	}
}

?>
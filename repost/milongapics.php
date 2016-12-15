<?php
require_once("rsstools.php");
$debug=false;
$nb=getparam("nb",6);
$width=getparam("width",120);


showrecentpics("http://api.flickr.com/services/feeds/groups_pool.gne?id=386755@N22&lang=en-us&format=rss_200",$nb,$width);

?>



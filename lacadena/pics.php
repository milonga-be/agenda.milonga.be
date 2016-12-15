<?php
require_once("../../tools.forret.com/lib/simplepie/simplepie.inc");
require_once("../../lib/template.inc");
$debug=true;
$source=getparam("source","fav");

tmpl_setbase("_tpl");
tmpl_header("Milonga.be photos for La Cadena");

echo "<p>";
echo "[<a href='?source=fav'>Favourites</a>] ";
echo "[<a href='?source=all'>Recent</a>] ";
echo "</p>";

switch($source){
case "fav":
	showrecentpics("http://api.flickr.com/services/feeds/groups_pool.gne?id=386755@N22&lang=en-us&format=rss_200",10);
	break;
case "all":
	showrecentpics("http://api.flickr.com/services/feeds/photos_public.gne?id=37855527@N00&tags=milonga&lang=en-us&format=rss_200",20);
	break;
default:
	// rien
}
tmpl_footer();


function extractThumbFromDesc($description){
	// we're looking for http://farm2.static.flickr.com/1033/1356125309_d512e4aea7_m.jpg

	$found=preg_match_all(
		"|http://[a-z0-9]*.staticflickr.com/[/0-9a-z_]*_m.jpg|U",
		$description,
		$matches, PREG_PATTERN_ORDER);

	$temp3 = str_replace("_XX.jpg","_s.jpg",$matches[0][0]);

	return $temp3;
}

function RemoveHTML($html){
	return preg_replace("#<[^>]*>#","",$html);
}

function showrecentpics($url,$num_items=6){
	$height=120;
	$width=round($height*1.5);
	$feed = new SimplePie();
	$xml=graburl($url);
	//$feed->set_feed_url($url);
	$feed->set_raw_data($xml);
	$feed->init();
	$feed->handle_content_type();

	 if ($feed->data):
		$items = $feed->get_items();
		$feedtitle=$feed->get_title();
		$itemnr=0;
		$lastdate="";
		$lasttit="";
		echo "<h3>Source: <a href='$url'>$feedtitle</a></h3>";
		foreach($items as $item):
			$itemnr+=1;
			$title=$item->get_title();
			if($itemnr<= $num_items){
				$thisdate=$item->get_date();
				$thislink=$item->get_link();
				$datetaken=$item->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, "date.Taken");
				if($datetaken){
					$datetaken=$datetaken[0]["data"];
					$thisdate=$datetaken;
				}
				$thisdesc=$item->get_description();
				$encl=$item->get_enclosures();
				$descr=$encl[0]->get_description();
				$descr=str_ireplace(Array("&lt;","&gt;","&amp;","&quot;"),Array("<",">","&",'"'),$descr);
				$descr=txt_removehtml($descr);
				$descr=trim(str_replace("www.milonga.be","",$descr));
				$thisday=date("Y-m-d",strtotime($thisdate));
				$thistit=$thisday.substr($title,0,5);
				if($thistit <> $lasttit){
					echo "<div style='clear: both'></div>\n";
					echo "<h4>$thisday: $title</h4>\n";
					$lasttit=$thistit;
				}
				$ThumbURL=extractThumbFromDesc($item->get_content());
				$OrigURL=str_replace("/in/","/sizes/o/in/",$thislink);
				if($num_items>20)	$height=80;
				echo "<div style='float: left; padding: 4px;'><img border='0' height='$height' title=\"". $title ."\" src='" . $ThumbURL . "' /><br />";
				echo "<small><a href='$thislink'>Flickr</a> <a target='_blank' href='$OrigURL'>Hi-Res</a><br />\n";
				if($descr) echo "<div style='width: ${width}px'>$descr</div>";
				echo "</small></div> \n" ;
			}
		 endforeach;
		echo "<br />\n";
	 endif;
}

?>



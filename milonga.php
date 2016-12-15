<?php
require_once("../lib/simplepie/simplepie.inc");
require_once("../lib/tools.inc");
$debug=false;


showtitle("Milonga news","http://www.milonga.be");
showrecentposts("http://feeds2.feedburner.com/MilongaBlog",5);

//echo "<div style='font-size: .8em'>";
//showtitle("Brussels Tango Festival 2012 forum","http://list.milonga.be/forum/");
//showrecentposts("http://list.milonga.be/forum/rss.php",6,25);
//echo "</div>";

showtitle("Milonga photos","http://www.milonga.be/about/tango-photos/");
showrecentpics("http://api.flickr.com/services/feeds/groups_pool.gne?id=386755@N22&lang=en-us&format=rss_200",5,120);

// showtitle("Milonga announcements","http://agenda.milonga.be");
// showrecentpics("http://api.flickr.com/services/feeds/photoset.gne?set=72157629227970560&nsid=37855527@N00&lang=en-us&format=rss_200",3,120);

//showtitle("Upcoming tango festivals","http://www.milonga.be/dancing/festivals/");
//showrecentposts("http://tools.forret.com/parss/rss.php?c=festivals",4,365,false);
 
//showtitle("Upcoming tango marathons","http://www.milonga.be/dancing/marathons/");
//showrecentposts("http://tools.forret.com/parss/rss.php?c=marathons",4,365,false);

showtitle("Tango classes","http://www.milonga.be/classes/");
include("courses.php");

function extractThumbFromDesc($description){
	// we're looking for http://farm2.static.flickr.com/1033/1356125309_d512e4aea7_m.jpg

	$found=preg_match_all(
		"|http://[a-z0-9]*.staticflickr.com/[/0-9a-z_]*_m.jpg|U",
		$description,
		$matches, PREG_PATTERN_ORDER);

	$temp3 = str_replace("_m.jpg","_s.jpg",$matches[0][0]);

	return $temp3;
}

function showtitle($text,$url){
	echo "\n<div style='font-family: Verdana, Helvetica, Arial, Sans-serif; font-weight: bold; margin-top: 2px; margin-bottom: 2px;'><A HREF='" . $url . "'>= " . $text . " =</A></div>\n";
}

function RemoveHTML($html){
	return preg_replace("#<[^>]*>#","",$html);
}

function showrecentposts($url,$num_items=3,$max_age=30,$show_date=true){
	trace("$url - $num_items - $max_age - $show_date");
	$feed = new SimplePie();
	$xml=graburl($url);
	$xml=str_replace(""," ",$xml);
	//$feed->set_feed_url($url);
	$feed->set_raw_data($xml);

	$feed->init();
	//$feed->handle_content_type();
	if ($feed->error())	{
		trace($feed->error());
	}

	if ($feed->data){
		$items = $feed->get_items();
		trace("showrecentposts: found " . count($items) . " items");
		$itemnr=0;
		$lasttitle="";
		foreach($items as $item){
			$itemnr+=1;
			$itemdate="";
			$itemage=100;
			$itemtitle=$item->get_title();
			//echo "<!-- #$itemnr - $itemtitle -->\n";
			$itemtitle=str_replace(Array("?","admin on"),"",$itemtitle);
			//$itemtitle=preg_replace("#^[\w\-\.\s]* on #","",$itemtitle);
			$itemtitle=txt_shortentext($itemtitle,60);
			$itemdate=$item->get_date();
			if($itemdate) {
				$itemage=(strtotime(date("c"))-strtotime($itemdate))/(3600*24);
			}
			if($itemnr<= $num_items AND $itemage < $max_age){
				if($itemtitle <> $lasttitle){
					echo "&bull; $itemtitle";
					if($itemdate AND $show_date) {
						$strend=strpos($itemdate," ",5);
						echo "<span style='font-size: .75em'> (" . substr($itemdate,0,$strend) . ")</span><br />";
					} else {	
						echo "<br />";
					}
				}
				$content=$item->get_content();
				$content=RemoveHTML($content);
				if(strlen($content)>80){
					$content=substr($content,0,strpos($content," ",80));
				}
				if($content){
					echo "<span style='font-size: .75em; color: #666'>$content ...</span><br />";
					}
				//echo "<br />";
			}
			$lasttitle=$itemtitle;
		}
		echo "<br />\n";
	} else {
		trace("showrecentposts: no items found");
	}
}

function showrecentpics($url,$num_items=6,$height=150){
	$feed = new SimplePie();
	$xml=graburl($url);
	//$feed->set_feed_url($url);
	$feed->set_raw_data($xml);
	$feed->init();
	$feed->handle_content_type();

	 if ($feed->data):
		$items = $feed->get_items();
		$itemnr=0;
		foreach($items as $item):
			$itemnr+=1;
			$title=$item->get_title();
			if($itemnr<= $num_items){
				$ThumbURL=extractThumbFromDesc($item->get_content());
				$ThumbURL=str_replace("_s.","_m.",$ThumbURL);
				echo "<img height='$height' title=\"". $title ."\" src='" . $ThumbURL . "' /> \n" ;
			}
		 endforeach;
		echo "<br />\n";
	 endif;
}
$fspecial="special.php";
if(file_exists($fspecial)) $special=trim(file_get_contents($fspecial));
if(strlen($special)>0){
	showtitle("SPECIAL","");
	echo $special;
}


?>



<?php
require_once("../../lib/simplepie/simplepie.inc");
require_once("../../lib/tools.inc");


function extractThumbFromDesc($description){
	// we're looking for http://farm2.static.flickr.com/1033/1356125309_d512e4aea7_m.jpg

	$found=preg_match_all(
		"|http://[a-z0-9]*.staticflickr.com/[/0-9a-z_]*_m.jpg|U",
		$description,
		$matches, PREG_PATTERN_ORDER);

	$temp3 = str_replace("_m.jpg","_s.jpg",$matches[0][0]);

	return $temp3;
}

function RemoveHTML($html){
	return preg_replace("#<[^>]*>#","",$html);
}

function showrecentposts($url,$num_items=3,$max_age=30,$show_date=true){
	trace("$url - $num_items - $max_age - $show_date");
	$feed = new SimplePie();
	$xml=graburl($url,true,60);
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
	$xml=graburl($url,true,300);
	//$feed->set_feed_url($url);
	$feed->set_raw_data($xml);
	$feed->init();
	$feed->handle_content_type();

	$output="";
	 if ($feed->data):
		$items = $feed->get_items();
		$itemnr=0;
		foreach($items as $item):
			$itemnr+=1;
			$title=htmlentities(utf8_decode($item->get_title()));
			$itemdate=$item->get_date();
			$itemtime=strtotime($itemdate);
			//var_dump($item);
			if($itemnr<= $num_items){
				trace("#$itemnr: $title");
				$itemdate=$item->get_date();
				$itemlink=$item->get_link();
				if(!$lasttime OR $lasttime < $itemtime)	$lasttime=$itemtime;
				if(!$firsttime OR $firsttime > $itemtime)	$firsttime=$itemtime;
				$ThumbURL=extractThumbFromDesc($item->get_content());
				$ThumbURL=str_replace("_s.","_m.",$ThumbURL);
				$output.="<a href=\"$itemlink\"><img height='$height' title=\"". $title ."\" src='" . $ThumbURL . "' /></a> \n" ;
			}
		 endforeach;
		 $firstdate=date("M j",$firsttime);
		 $lastdate=date("M j, Y",$lasttime);
		 trace("First date: $firstdate");
		 trace("Last date: $lastdate");
		 echo "<html><head>\n<title>Recent pictures from Flickr</title>\n</head><body>\n";
		 echo "<p>Photos: $firstdate - $lastdate</p>\n";
		 echo "$output\n";
		 echo "</body></html>\n";
		 endif;
}


?>



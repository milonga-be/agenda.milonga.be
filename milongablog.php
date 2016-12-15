<?php
require_once("../lib/simplepie/simplepie.inc");
require_once("../lib/tools.inc");
$debug=false;
$nb=getparam("nb",5);
$width=getparam("width",120);


showtitle("Milonga news","http://www.milonga.be");
showrecentposts("http://feeds2.feedburner.com/MilongaBlog",2,30,false);

function showtitle($text,$url){
	echo "\n<div style='font-family: Verdana, Helvetica, Arial, Sans-serif; font-weight: bold; margin-top: 2px; margin-bottom: 2px;'><A HREF='" . $url . "'>= " . $text . " =</A></div>\n";
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


?>



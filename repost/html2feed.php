<?php
include_once("settings.php");
$folder=getparam("folder","items");
$days=getparam("days",7);
$title=getparam("title","milonga.be newsletter");
$description=getparam("description","news on tango in Belgium");
$thisurl="http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
$link=getparam("link",$thisurl);

    $rssfeed = '<?xml version="1.0" encoding="utf8"?>';
    $rssfeed .= "<rss version=\"2.0\">\n";
    $rssfeed .= "<channel>\n";
    $rssfeed .= "<title>$title</title>\n";
    $rssfeed .= "<link>$link</link>\n";
    $rssfeed .= "<description>$description</description>\n";
    $rssfeed .= "<language>en-us</language>\n";
    $rssfeed .= "<copyright>Copyright (C) 2015 www.milonga.be</copyright>\n";
    
    $pages=listfiles($folder,".html");
    foreach($pages as $page){
    	$modif=filemtime($page);
    	$secsago=time()-$modif;
    	$daysago=round($secsago/(3600*24),1);
    	if($daysago < $days){
    		$html=file_get_contents($page);
			$title2=gettagfromhtml($html,"title",false);
			if($title2){
				$title=$title2;
			} else {
				$title=basename($page,".html");
				$title=str_replace(Array(".","_")," ",$title);
				$title=ucwords(strtolower($title));
			}
    		$guid=sha1("$title$modif");
			$rssfeed .= "<item>\n";
			$rssfeed .= "<title>$title</title>\n";
			$rssfeed .= "<description><![CDATA[$html]]></description>\n";
			$rssfeed .= "<link>$link</link>\n";
			$rssfeed .= "<guid>$guid</guid>\n";
			$rssfeed .= "<pubDate>" . date("D, d M Y H:i:s O", $modif) . "</pubDate>\n";
			$rssfeed .= "</item>\n";  
        }
    }
    $rssfeed .= "</channel>\n";
    $rssfeed .= "</rss>\n";
 
header('Content-Type: application/rss+xml; charset=utf-8');
echo $rssfeed;

?>
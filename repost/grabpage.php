<?php
include_once("settings.php");
tmpl_header("Grab page");
$folder=getparam("folder","items");
$folder=substr(preg_replace("#([^\d\w_])#","",$folder),0,20);
echo "<li>Folder: <code>[$folder]</code></li>";
if(!file_exists($folder)){
	echo "<li>Creating <code>[$folder]</code></li>";
	mkdir($folder);
}
$url=getparam("url","http://agenda.milonga.be/milongapics.php");
$url=htmlentities($url);
echo "<li>URL: <code>[$url]</code></li>";

$title=getparam("title");
$html=graburl($url,true,60);
$contentok=true;
if(contains($html,"504 Gateway Time-out")){
	echo "<li>Data: Error 504 - no content found</li>";
	$contentok=false;
}
if(strlen($html)<100){
	echo "<li>Data: no content found</li>";
	$contentok=false;
}
if($contentok){
	$uname=basename($url);
	$uname=str_replace(Array(".html",".htm",".php"),"",$uname);
	trace($urlparts);
	if(contains($html,"<body")){
		// take just the <body>...</body> part
		$title2=gettagfromhtml($html,"title",$include=false);
		trace("Title from content: [$title2]");
		if(!$title){
			if($title2){
				$title=$title2;
			} else {
				$title=$uname;
			}
		}
		$body=gettagfromhtml($html,"body",$include=false);
	} else {
		$title2=gettagfromhtml($html,"title",$include=false);
		trace("Title from content: [$title2]");
		if(!$title){
			if($title2){
				$title=$title2;
			} else {
				$title=$uname;
			}
		}
		if($title2){
			$body=preg_replace("#(<title>.*</title>)#","",$html);
		} else {
			$body=$html;
		}
	}

	$fname=str_replace(" ","_",$title).".html";
	$fname=preg_replace("#([^\d\w_\-\.])#","_",$fname);
	echo "<li>Save as: <code>[$fname]</code></li>";
	trace("deduce filename: [$title] => [$fname]");
	$fpath="$folder/$fname";
	if($fpath & $body){
		file_put_contents($fpath,$body);
		$bytes=strlen($body);
		echo "<li>Saved! <code>$bytes bytes</code></li>";
	}
} else {
	
}
tmpl_footer();

?>

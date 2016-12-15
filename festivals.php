<?php
include_once("../lib/template.inc");
$debug=true;
tmpl_setbase("_tpl");
tmpl_header(" ");
$url = "https://tango.info/festivals/2015";

$raw=graburl($url);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$raw = curl_exec($curl);
curl_close($curl);

if(strpos($raw,'<table class="listing sortable')){
	// cut preamble
	$raw=substr($raw,strpos($raw,'<table class="listing sortable'));
}
if(strpos($raw,'<div class="ti_footer_outer">')){
	// cut postamble
	$raw=substr($raw,0,strpos($raw,'<div class="ti_footer_outer">'));
}

echo $raw;

tmpl_footer();

?>
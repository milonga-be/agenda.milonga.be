<?php

session_cache_limiter('public');
$filter="";
$maxlen=120;
if (isset($_GET['f'])) $filter=$_GET['f'];
define('BASE', './');
require_once(BASE.'functions/date_functions.php');
require_once(BASE.'functions/init.inc.php');
$current_view 		='print';

$start_week_time 	= strtotime($getdate);
//$start_week_time 	= strtotime(dateOfWeek($getdate, $week_start_day));
$nbweeks=1;
if (isset($_GET['weeks']))	$nbweeks = $_GET['weeks'];
$end_week_time 		= $start_week_time + ($nbweeks * 7 * 24 * 60 * 60);
$parse_month 		= date ("Ym", strtotime($getdate));
$events_week 		= 0;
$unix_time 			= strtotime($getdate);
$printview = 'day';
if (isset($_GET['printview']))	$printview = $_GET['printview'];

if ($printview == 'day') {
	$display_date 	= localizeDate ($dateFormat_day, strtotime($getdate));
	$next 			= date("Ymd", strtotime("+1 day", $unix_time));
	$prev 			= date("Ymd", strtotime("-1 day", $unix_time));
	$week_start		= '';
	$week_end		= '';
} elseif ($printview == 'week') {
	$start_week 	= localizeDate($dateFormat_week, $start_week_time);
	$end_week 		= localizeDate($dateFormat_week, $end_week_time);
	$display_date 	= "$start_week - $end_week";
	$week_start 	= date("Ymd", $start_week_time);
	$week_end 		= date("Ymd", $end_week_time);
	$next 			= date("Ymd", strtotime("+1 week", $unix_time));
	$prev 			= date("Ymd", strtotime("-1 week", $unix_time));
} elseif ($printview == 'month') {
	$display_date 	= localizeDate ($dateFormat_month, strtotime($getdate));
	$next 			= date("Ymd", strtotime("+1 month", $unix_time));
	$prev 			= date("Ymd", strtotime("-1 month", $unix_time));
	$week_start		= '';
	$week_end		= '';
} elseif ($printview == 'year') {
	$display_date 	= localizeDate ($dateFormat_year, strtotime($getdate));
	$next 			= date("Ymd", strtotime("+1 year", $unix_time));
	$prev 			= date("Ymd", strtotime("-1 year", $unix_time));
	$week_start		= '';
	$week_end		= '';
}
require_once(BASE.'functions/ical_parser.php');
require_once(BASE.'functions/list_functions.php');
require_once(BASE.'functions/template.php');
header("Content-Type: text/plain; charset=$charset");
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s',time()+60*60*3) . ' GMT');
$template="fortumo";
$page = new Page(BASE.'templates/'.$template.'/print.tpl');

$page->replace_files(array(
	'header'			=> BASE.'templates/'.$template.'/header.tpl',
	'footer'			=> BASE.'templates/'.$template.'/footer.tpl',
	'sidebar'			=> BASE.'templates/'.$template.'/sidebar.tpl'
	));

$page->replace_tags(array(
	'version'			=> $phpicalendar_version,
	'event_js'			=> '',
	'language_select' 	=> "fr",
	'charset'			=> $charset,
	'default_path'		=> '',
	'template'			=> $template,
	'cal'				=> $cal,
	'getdate'			=> $getdate,
	'calendar_name'		=> $cal_displayname,
	'current_view'		=> $current_view,
	'printview'			=> $printview,
	'display_date'		=> $display_date,
	'sidebar_date'		=> $sidebar_date,
	'rss_powered'	 	=> $rss_powered,
	'rss_available' 	=> '',
	'rss_valid' 		=> '',
	'show_search' 		=> '',
	'next_day' 			=> $next_day,
	'prev_day'	 		=> $prev_day,
	'show_goto' 		=> '',
	'is_logged_in' 		=> '',
	'list_icals' 		=> $list_icals,
	'list_years' 		=> $list_years,
	'list_months' 		=> $list_months,
	'list_weeks' 		=> $list_weeks,
	'list_jumps' 		=> $list_jumps,
	'legend'	 		=> $list_calcolors,
	'style_select' 		=> $style_select,
	'l_time'			=> $lang['l_time'],
	'l_summary'			=> $lang['l_summary'],
	'l_description'		=> $lang['l_description'],
	'l_calendar'		=> $lang['l_calendar'],
	'l_day'				=> $lang['l_day'],
	'l_week'			=> $lang['l_week'],
	'l_month'			=> $lang['l_month'],
	'l_year'			=> $lang['l_year'],
	'l_location'		=> $lang['l_location'],
	'l_subscribe'		=> $lang['l_subscribe'],
	'l_download'		=> $lang['l_download'],
	'l_no_results'		=> $lang['l_no_results'],
	'l_powered_by'		=> $lang['l_powered_by'],
	'l_this_site_is'	=> $lang['l_this_site_is']
	));


if($filter)
	$page->draw_filter($page,$filter);
else
	$page->draw_print($page);


$text=$page->page;

$aevents=explode("\\n",$text);

$milongas="";
$workshops="";
$performances="";
$practicas="";
foreach($aevents as $event){
	if(strpos($event,":")){
		list($type,$rest)=explode(":",$event,2);
		$type=strtoupper(trim($type));
		list($what,$when)=explode(";",$rest);
		$what=trim($what);
		$what=str_replace(Array("Bruxelles","Brussels","Brussel"),"Bxl",$what);
		$what=str_replace(Array("Antwerpen","Antwerp","Anvers"),"Antw",$what);
		$what=str_replace(Array("Hasselt","Leuven","Gent"),Array("Hass","Leuv","Gnt"),$what);
		$what=str_replace(" @ ","@",$what);
		$when=preg_replace("# \- \d*:\d* .M#","",$when);
		$when=str_replace(Array(" PM"," AM",":00"),Array("pm","am",""),$when);
		switch($type){
			case "MILONGA":
			case "SALON":
				$milongas.="$what,$when;";
				break;
			case "WORKSHOP":
				$workshops.="$what,$when;";
				break;
			case "CONCERT":
			case "PERFORMANCE":
				$performances.="$what,$when;";
				break;
			case "PRACTICA":
				$practicas.="$what,$when;";
				break;
		}
	}
}

$text="";
if($milongas) 	$text.="MILONGA:$milongas ";
if($performances)  $text.="PERFORMANCE:$performances ";
if($workshops)  $text.="WORKSHOP:$workshops ";
if($practicas)  $text.="PRACTICA:$practicas ";
$text=trim($text);
if($text){
if(strlen($text)>$maxlen)
	print substr($text,0,$maxlen-1)."…";
else
	print $text;
} else {
	print "Nothing found for '$filter' for today - www.milonga.be";
}
	// "MIL:Patio de Tango@BXL,6:30pm;WRK:Cours de musicalité en tango@BXL,7:00pm;PRA:TangoQuerido@BXL,7:30pm;PRA:La Tangueria@B"
?>

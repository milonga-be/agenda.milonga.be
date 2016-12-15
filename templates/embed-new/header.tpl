<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset={CHARSET}" />
	<title>{CALENDAR_NAME} calendar - {DISPLAY_DATE} | agenda.milonga.be - Tango in Belgium</title>
	<META NAME="Keywords" CONTENT="agenda,argentine,argentino,bal,belgie,belgien,belgique,belgium,calendar,calendrier,concert,evenement,event,kalender,milonga,salon,tango">
	<META NAME="Description" CONTENT="Tango calendar for Argentine tango in Belgium">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="{DEFAULT_PATH}templates/{TEMPLATE}/default.css" />
	<link rel="stylesheet" type="text/css" href="{DEFAULT_PATH}templates/{TEMPLATE}/css/tooltipster.bundle.min.css" />
	<link rel="stylesheet" type="text/css" href="{DEFAULT_PATH}templates/{TEMPLATE}/css/tooltipster-sideTip-shadow.min.css" />
	<link rel="stylesheet" type="text/css" href="{DEFAULT_PATH}templates/{TEMPLATE}/font-awesome-4.7.0/css/font-awesome.min.css" />
	<!-- switch rss_available on -->
	<link rel="alternate" type="application/rss+xml" title="RSS" href="{DEFAULT_PATH}/rss/rss.php?cal={CAL}&amp;rssview={CURRENT_VIEW}">
	<!-- switch rss_available off -->		
	{EVENT_JS}
	<script type="text/javascript">
	/* document.domain = "milonga.be"; */
	document.domain = "milonga.be";
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="/templates/embed-new/js/jquery.expander.min.js"></script>
	<script src="/templates/embed-new/js/tooltipster.bundle.min.js"></script>
	<script type="text/javascript">
		$(function(){ /* to make sure the script runs after page load */

			$('.milonga-description').expander({
			  slicePoint: 300,
			  widow: 2,
			  expandEffect: 'slideDown',
			  collapseEffect: 'slideUp',
			  expandText: '...READ MORE',
			  userCollapseText: 'LESS',
			  afterExpand : function(){ window.parent.resizeIframe(); },
			  afterCollapse : function(){ window.parent.resizeIframe(); },
			});
			
			// Enable tooltips
			$('.tooltip').tooltipster({
				theme: 'tooltipster-shadow'
			});
		});
	</script>
</head>
<body>
<form name="eventPopupForm" id="eventPopupForm" method="post" action="includes/event.php" style="display: none;">
  <input type="hidden" name="date" id="date" value="" />
  <input type="hidden" name="time" id="time" value="" />
  <input type="hidden" name="uid" id="uid" value="" />
  <input type="hidden" name="cpath" id="cpath" value="" />
  <input type="hidden" name="event_data" id="event_data" value="" />
</form>
<!-- <center>
	<img width="860" src="http://www.milonga-belgium.be/wp-content/uploads/2016/09/cropped-banner_milonga_be.jpg"/>
</center> -->
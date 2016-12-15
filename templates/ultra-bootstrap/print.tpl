{HEADER}

<!-- switch some_events on -->
<a name="{DAYOFMONTH}"></a><h3 class="V12">{DAYOFMONTH}</h3>
<!-- loop events on -->
<div class="V13">
	<h4>{EVENT_TEXT}</h4>
	<!--img width="16" height="16" src="http://agenda.milonga.be/images/time.gif" alt="When"--><div style="milonga-data">{EVENT_START}<br/>
	<!--img width="16" height="16" src="http://agenda.milonga.be/images/house.gif" alt="Where"-->{LOCATION}</div>
	<div class="milonga-description" style="/*padding-left: 20px;*/  /*font-style: italic;*/">
		{DESCRIPTION}
	</div>
	<!-- <div class="milonga-separator">&#x273D;</div> -->
</div>
<!-- loop events off -->
<!-- switch some_events off -->

<!-- switch no_events on -->
<div class="V12"><b>{L_NO_RESULTS}</b></div>
<!-- switch no_events off -->

{FOOTER}
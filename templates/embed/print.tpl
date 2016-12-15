{HEADER}
<center>
<table border="0" width="480" cellspacing="0" cellpadding="0" class="calborder">
<tr>
	<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="banner">
		<tr valign="top">
			<td align="left" width="400" class="title"><h1>{DISPLAY_DATE}</h1><A target="_top" HREF="http://www.milonga.be/dancing/">{CALENDAR_NAME} {L_CALENDAR}</a> &bull; <A HREF="?printview=day">today</A> - <A HREF="?weeks=1">this week</A></td>
			<td valign="top" align="right" width="200" class="navback">	
			<div style="padding-top: 3px;">
			<form action="filter.php" method="get">
				<input type="text" name="filter" size="8" class="searchbox" />
				<input type="hidden" name="weeks" value="8" />
				<input type="submit" value="Search!" class="searchbox" />
			</form>
			</div>
			</td>
		</tr>  			
	</table>
	</td>
</tr>
<tr>
<td colspan="3" class="dayborder"><img src="images/spacer.gif" width="1" height="5" alt=" " /></td>
</tr>
<tr>
<td colspan="3" style="text-align: left">
		<!-- switch some_events on -->
		<a name="{DAYOFMONTH}"></a><h3 class="V12">{DAYOFMONTH}</h3>
		<!-- loop events on -->
		<div class="V13">
			<h4>{EVENT_TEXT}</h4>
			<img width="16" height="16" src="http://agenda.milonga.be/images/time.gif" alt="When">&nbsp;{EVENT_START}<br />
			<img width="16" height="16" src="http://agenda.milonga.be/images/house.gif" alt="Where">&nbsp;{LOCATION}<br />
			<div style="padding-left: 20px; padding-top: 4px; color: #333; font-style: italic">
				{DESCRIPTION}
			</div>
		</div>
		<!-- loop events off -->
		<!-- switch some_events off -->

		<!-- switch no_events on -->
		<div class="V12"><b>{L_NO_RESULTS}</b></div>
		<!-- switch no_events off -->
</td>
</tr>
</table>
<table width="480" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tbll"><img src="images/spacer.gif" alt="" width="8" height="4" /></td>
		<td class="tblbot"><img src="images/spacer.gif" alt="" width="8" height="4" /></td>
		<td class="tblr"><img src="images/spacer.gif" alt="" width="8" height="4" /></td>
	</tr>
</table>
</center>
{FOOTER}
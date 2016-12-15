{HEADER}
<h1>Milonga Agenda</h1>
<p><small>
<A HREF="?weeks=1">ALL</A> ||
<A HREF="?filter=brussels">BXL</A> |
<A HREF="?filter=antwerp">ANTW</A> |
<A HREF="?filter=@ Gent">GENT</A> ||
<A HREF="?filter=concert">Concerts</A> |
<A HREF="?filter=workshop">Workshops</A>
</small></p>
<!-- h2>{DISPLAY_DATE}</h2 -->
<!-- switch some_events on -->
<h3>{DAYOFMONTH}</h3>
<!-- loop events on -->
<p>
<A HREF="http://agenda.milonga.be/filter.php?filter={_EVENT_TEXT}"><b>{EVENT_TEXT}</b></A><br />
<img src="http://agenda.milonga.be/images/time.gif" alt="When">&nbsp;{EVENT_START}<br />
<img src="http://agenda.milonga.be/images/house.gif" alt="Where">&nbsp;{LOCATION}
</p>
<!-- loop events off -->
<!-- switch some_events off -->
{FOOTER}
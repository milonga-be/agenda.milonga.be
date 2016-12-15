{HEADER}

<!-- switch some_events on -->
<div style="font-size: 16px; border-top: 1px #000 solid; font-weight: bold; margin-bottom:2px; margin-top: 6px; padding-top: 6px;">
<a href="http://agenda.milonga.be/day/?d={FULLDATE}">{DAYOFMONTH}</a>
</div>

<!-- loop events on -->

<div>{EVENT_BULLET} {EVENT_TEXT}</div>
<div style="font-size: .75em">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{EVENT_BEGIN} @ {LOCATION}<br /></div>

<!-- loop events off -->

<!-- switch some_events off -->
<p style="border-top: 2px #000 solid; "></p>
<div style="font-size: .5em; color: #FFF">------------------------------------------------------------</div>

{FOOTER}

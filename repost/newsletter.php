<?php
include_once("settings.php");
tmpl_header("Repost Newsletter");

?>
<h2>Newsletter</h2>
<h3>Input</h3>
<dl>
<dt>Pictures</dt>
<dd><a href='http://agenda.milonga.be/repost/milongapics.php'>source</a></dd>
<dd><a href='http://agenda.milonga.be/repost/grabpage.php?folder=newsletter&url=http://agenda.milonga.be/repost/milongapics.php'>grab</a></dd>
<dt>Agenda</dt>
<dd><a href='http://agenda.milonga.be/newsletter2.php'>source</a></dd>
<dd><a href='http://agenda.milonga.be/repost/grabpage.php?folder=newsletter&url=http://agenda.milonga.be/newsletter2.php'>grab</a></dd>
</dl>
<h3>Feed</h3>
<dl>
<dt>RSS feed</dt>
<dd><a href='http://agenda.milonga.be/repost/html2feed.php?folder=newsletter&days=7&title=&title=&link=http%3A%2F%2Fwww.milonga.be'>rss</a></dd>
</dl>



<?php
tmpl_footer();
?>

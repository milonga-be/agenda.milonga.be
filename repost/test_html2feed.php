<?php
include_once("settings.php");
tmpl_header("Grab page");

echo "<form method='get' action='html2feed.php'><dl>";
echo "<dt>Folder: <small>(where the items are saved)</small></dt><dd><input type='text' size=10 name='folder' value='test' /></dd>\n";
echo "<dt>Days: <small>(only items less than N days old)</small></dt><dd><input type='days' size=1 name='days' value='7' /></dd>\n";
echo "<dt>Title: <small>(RSS Feed title)</small></dt><dd><input type='text' size=20 name='title' value='' /></dd>\n";
echo "<dt>Description: <small>(RSS Feed description)</small></dt><dd><input type='text' size=20 name='title' value='' /></dd>\n";
echo "<dt>Link: <small>(RSS feed URL to website)</small></dt><dd><input type='text' size=50 name='link' value='http://www.milonga.be' /></dd>\n";
echo "<dt>&nbsp;</dt><dd><input type='submit' title='View!'></dd>";
echo "</dl></form>";

tmpl_footer();

?>

<?php
include_once("settings.php");
tmpl_header("Grab page");

echo "<form method='get' action='grabpage.php'><dl>";
echo "<dt>URL: <small>(content to grab)</small></dt><dd><input type='text' size=50 name='url' value='http://' /></dd>\n";
echo "<dt>Title: <small>(Override page title)</small></dt><dd><input type='text' size=20 name='title' value='' /></dd>\n";
echo "<dt>Folder: <small>(where the item will be saved)</small></dt><dd><input type='text' size=10 name='folder' value='test' /></dd>\n";
echo "<dt>&nbsp;</dt><dd><input type='submit' title='Grab!'></dd>";
echo "</dl></form>";

tmpl_footer();

?>

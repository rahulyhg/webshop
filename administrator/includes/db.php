<?php

$link = mysql_connect("localhost", "root", "root") or die("Error in Connection. Check Server Configuration.");
mysql_select_db("roomrent", $link) or die("Database not Found. Please Create the Database.");
?>
<?php
$verbindung = mysql_connect ($hostname, $username, $password) or die ("Can't connect to database!");
mysql_select_db($database) or die ("The database doesn't exists!");
?>
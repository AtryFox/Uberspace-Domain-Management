<?php
//$verbindung = mysql_connect ($hostname, $username, $password) or die ("Can't connect to database!");
//mysql_select_db($database) or die ("The database doesn't exists!");

$mysqli = new mysqli($hostname, $username, $password, $database);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


try {
	$pdo = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
}

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
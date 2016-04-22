<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

if (!getLoggedin()) {
	header("Location: ../");
	exit;
}


if (!isset($_GET["id"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

$q = $mysqli->query("SELECT * FROM " . $t_domains . " WHERE id = '" . $_GET["id"] . "';");
while ($r = mysqli_fetch_array($q)) {
	if (is_link($dir . $r["domain"])) {
		unlink($dir . $r["domain"]);
	}
	if (is_link($dir . "www." . $r["domain"])) {
		unlink($dir . "www." . $r["domain"]);
	}

	$mysqli->query("DELETE FROM " . $t_domains . " WHERE id = '" . $r["id"] . "';");
}

setcookie("msg", "E07", time() + 60, "/");
header("Location: index.php");
//echo mysql_error();
<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();

if (!isset($_GET["id"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

$s = $pdo->prepare("SELECT * FROM $t_domains WHERE id = :id");
$s->execute(array('id' => $_GET["id"]));

while ($r = $s->fetch()) {
	if (is_link($dir . $r["domain"])) {
		unlink($dir . $r["domain"]);
	}
	if (is_link($dir . "www." . $r["domain"])) {
		unlink($dir . "www." . $r["domain"]);
	}

	$s_delete = $pdo->prepare("DELETE FROM $t_domains WHERE id = :id");
	$s_delete->execute(array('id' => $r["id"]));
}

setcookie("msg", "E07", time() + 60, "/");
header("Location: index.php");
//echo mysql_error();
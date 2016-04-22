<?php
include("../config.php");
include("../functions/mysql.php");
include("../functions/main.php");

$username = strtolower($_POST["username"]);
$password = makeHash($_POST["password"]);

$s = $pdo->prepare("SELECT password FROM $t_users WHERE username = :username AND password = :password LIMIT 1");
$s->execute(array('username' => $username, 'password' => $password));

while ($r = $s->fetch()) {
	setcookie("name", $username, time() + (3600 * 24 * 365), "/");
	setcookie("key", $password, time() + (3600 * 24 * 365), "/");
	setcookie("msg", "E00", time() + 60, "/");
	header("Location: ../index.php");
	exit;
}

setcookie("msg", "E01", time() + 60, "/");
header("Location: ../index.php");
exit;
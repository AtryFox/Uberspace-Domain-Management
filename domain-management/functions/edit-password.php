<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();

if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["newPassword1"]) || !isset($_POST["newPassword2"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

$username = $_POST["username"];
$password1 = $_POST["newPassword1"];
$password2 = $_POST["newPassword2"];

$s = $pdo->prepare("SELECT password, salt FROM $t_users WHERE username = :username LIMIT 1");
$s->execute(array('username' => $username));

$salt = "";

if($s->rowCount() != 1) {
	$msg = "E02";
	include("message.php");
	exit;
}

while ($r = $s->fetch()) {
	$salt = $r["salt"];

	if (makeSaltedHash($_POST["password"], $salt) != $r["password"]) {
		$msg = "E10";
		include("message.php");
		exit;
	}
}

if($password1 != $password2) {
	$msg = "E11";
	include("message.php");
	exit;
}

$password = makeHashSecure($password1, $salt);

$s = $pdo->prepare("UPDATE $t_users SET password = :password, salt = :salt WHERE username = :username");
$s->execute(array('password' => $password, 'salt' => $salt, 'username' => $username));

setcookie("name", "", 0, "/");
setcookie("key", "", 0, "/");
setcookie("msg", "E12", time()+60, "/");

header("Location: index.php");


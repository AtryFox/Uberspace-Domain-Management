<?php
include("../config.php");
include("../functions/mysql.php");
include("../functions/main.php");

error_reporting(E_ALL);

$username = $_POST["username"];

$s = $pdo->prepare("SELECT salt FROM $t_users WHERE username = :username LIMIT 1");
$s->execute(array('username' => $username));

if ($s->rowCount() == 1) {
	$salt = "";
	while ($r = $s->fetch()) {
		$salt = $r["salt"];
	}

	$s = $pdo->prepare("SELECT username, password FROM $t_users WHERE username = :username AND password = :password LIMIT 1");

	if (empty($salt)) {
		$password = makeHash($_POST["password"]);

		$s->execute(array('username' => $username, 'password' => $password));

		while ($r = $s->fetch()) {
			$saltedPassword = makeHashSecure($_POST["password"], $salt);

			$s = $pdo->prepare("UPDATE $t_users SET password = :password, salt = :salt WHERE username = :username AND password = :oldpassword");
			$s->execute(array('password' => $saltedPassword, 'salt' => $salt, 'username' => $username, 'oldpassword' => $password));
			
			setcookie("name", $r["username"], time() + (3600 * 24 * 365), "/");
			setcookie("key", $saltedPassword, time() + (3600 * 24 * 365), "/");
			setcookie("msg", "E00.1", time() + 60, "/");
			header("Location: ../index.php");
			exit;
		}
	} else {
		$password = makeSaltedHash($_POST["password"], $salt);

		$s->execute(array('username' => $username, 'password' => $password));
		while ($r = $s->fetch()) {
			setcookie("name", $r["username"], time() + (3600 * 24 * 365), "/");
			setcookie("key", $password, time() + (3600 * 24 * 365), "/");
			setcookie("msg", "E00", time() + 60, "/");
			header("Location: ../index.php");
			exit;
		}
	}
}

setcookie("msg", "E01", time() + 60, "/");
header("Location: ../index.php");
exit;
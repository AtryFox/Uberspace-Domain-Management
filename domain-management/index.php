<?php
$version = "1.3.1";

if (!file_exists("config.php")) {
	header("Location: install.php");
}

if (file_exists("config.php") && file_exists("install.php")) {
	unlink("install.php");
}

if (file_exists("config.php") && file_exists("update.php")) {
	header("Location: update.php");
}

if (isset($_COOKIE["msg"])) {
	$msg = $_COOKIE["msg"];
	setcookie("msg", "", 0, "/");
}

if (isset($_GET["p"])) {
	$site = strtolower($_GET["p"]);
} else {
	$site = "home";
}

$xButton = ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

require_once("config.php");
require_once("functions/main.php");
require_once("functions/mysql.php");

$dir = "/var/www/virtual/" . $uberspacename . "/";

if (!isset($_COOKIE["update"])) {
	setcookie("update", checkUpdate(), time() + (3600 * 24), "/");
} else {
	$updateStatus = $_COOKIE["update"];
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include("header.php"); ?>
</head>

<body>
<?php include("body.php"); ?>
</body>
</html>
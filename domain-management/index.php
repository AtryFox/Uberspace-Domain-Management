<?php
// INIT EVERYTHING //
$version = "1.5.0";

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

// CHECK FOR UPDATE
if (isset($_COOKIE["update"])) {
	$updateStatus = $_COOKIE["update"];
} else {
	$updateStatus = checkUpdate();
	setcookie("update", $updateStatus, time() + (3600), "/");
}


// MUSTACHE ENGINE
require 'assets/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();

$m = new Mustache_Engine(array(
	'loader'          => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/', array('extension' => '.html')),
	'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/', array('extension' => '.html')),
));

// INIT/DECLARE DATA ARRAY CONTAINING EVERYTHING THAT'S NEEDED FOR THE REQUESTED PAGE
require_once("data/main.php");
$data->Main = new Main();

switch ($site) {
	case "home":
		require_once("data/domains.php");
		$data->Domains = new Domains();
		break;
	case "edit-domain":
		require_once("data/domains.php");
		if (!isset($_GET["id"])) {
			setcookie("msg", "E02", time()+60, "/");
			header("Location: index.php");

			exit;
		}
		$data->Domain = new Domain($_GET["id"]);
		break;
	case "uberspace":
		require_once("data/uberspace.php");
		$data->Uberspace = new Uberspace();
		break;
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
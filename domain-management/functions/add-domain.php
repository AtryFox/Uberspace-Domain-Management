<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();


if (!isset($_POST["domain"]) || !isset($_POST["path"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

$domain = strtolower($_POST["domain"]);
$path = $dir . $_POST["path"] . "/";

if (!file_exists($path)) {
	setcookie("msg", "E03", time() + 60, "/");
	header("Location: ?p=add-domain");
	exit;
}

echo $path;

if (checkDomain($domain)) {
	setcookie("msg", "E04", time() + 60, "/");
	header("Location: ?p=add-domain");
	exit;
}

if (is_link($dir . $domain) || is_link($dir . "www." . $domain)) {
	setcookie("msg", "E06", time() + 60, "/");
	header("Location: ?p=add-domain");
	exit;
}

$mysqli->query("INSERT INTO " . $t_domains . " (domain) VALUES ('" . $mysqli->real_escape_string($domain) . "');");

symlink($path, $dir . $domain);
symlink($path, $dir . "www." . $domain);

setcookie("msg", "E05", time() + 60, "/");
//echo mysql_error();
header("Location: index.php");
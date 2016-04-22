<?php
error_reporting(0);

function getLoggedin()
{
	if (isset($_COOKIE["name"])) {
		if (isset($_COOKIE["key"])) {
			$username = $_COOKIE["name"];
			$password = $_COOKIE["key"];
			global $t_users, $pdo;

			$s = $pdo->prepare("SELECT password FROM $t_users WHERE username = :username AND password = :password LIMIT 1");
			$s->execute(array('username' => $username, 'password' => $password));

			while ($r = $s->fetch()) {
				return TRUE;
			}
			return FALSE;
		} else return FALSE;
	} else return FALSE;
}

function loginCheck($redirectPath = "../")
{
	if (!getLoggedin()) {
		header("Location: " . $redirectPath);
		exit;
	}
}

function makeHash($hashThis)
{
	for ($i = 0; $i < 42; $i++) $hashThis = hash("sha512", $hashThis);
	return $hashThis;
}

function checkDomain($domain)
{
	global $t_domains, $pdo;
	$s = $pdo->prepare("SELECT domain FROM $t_domains WHERE domain = :domain");
	$s->execute(array('domain' => $domain));
	while ($r = $s->fetch()) {
		return TRUE;
	}
	return FALSE;
}

function checkLink($link, $id)
{
	if (is_link($link)) {
		return "<span style='color: green;'>Verfügbar</span>";
	} else {
		return "<span style='color: red;'>Fehler <a href='?p=edit-domain&id=" . $id . "'>(Fix it!)</a></span>";
	}
}

function checkFolder($path1, $path2)
{
	if (!file_exists($path1) && $path1 != "" && !file_exists($path2) && $path2 != "") {
		return "<br><span style='color: red;'>Der angegebene Ordner existiert nicht mehr.</span>";
	}
}

function getLink($path1, $path2)
{
	if (readlink($path1) != "") {
		return readlink($path1);
	} else if (readlink($path2) != "") {
		return readlink($path2);
	} else {
		return "<span style='color: red;'>Der Link konnte nicht zurückverfolgt werden.</span>";
	}
}

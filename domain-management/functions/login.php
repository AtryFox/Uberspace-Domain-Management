<?php
include("../config.php");
if (!isset($tablepre)) {
    $tablepre = "";
}
$t_users = $tablepre . "users";
$t_domains = $tablepre . "domains";
include("../functions/mysql.php");
include("../functions/main.php");

$username = strtolower($_POST["username"]);
$password = makeHash($_POST["password"]);

$q = $mysqli->query("SELECT password FROM " . $t_users . " WHERE username = '" . $mysqli->real_escape_string($username) . "' AND password = '" . $mysqli->real_escape_string($password) . "'");
while ($r = mysqli_fetch_array($q)) {
    setcookie("name", $username, time() + (3600 * 24 * 365), "/");
    setcookie("key", $password, time() + (3600 * 24 * 365), "/");
    setcookie("msg", "E00", time() + 60, "/");
    header("Location: ../index.php");
    exit;
}
setcookie("msg", "E01", time() + 60, "/");
header("Location: ../index.php");
exit;
?>

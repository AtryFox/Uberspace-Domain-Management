<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();

if (!isset($_POST["id"]) || !isset($_POST["path"])) {
    $msg = "E02";
    include("message.php");
    exit;
}

$id = $_POST["id"];

$s = $pdo->prepare("SELECT * FROM $t_domains WHERE id = :id LIMIT 1");
$s->execute(array('id' => $id));

while ($r = $s->fetch()) {
    $domain = $r["domain"];
}

$path = $dir . $_POST["path"] . "/";

if (!file_exists($path)) {
    setcookie("msg", "E03", time() + 60, "/");
    header("Location: ?p=edit-domain&id=" . $id);
    exit;
}

echo $path;


if (is_link($dir . $domain)) {
    unlink($dir . $domain);
}

if (is_link($dir . "www." . $domain)) {
    unlink($dir . "www." . $domain);
}

symlink($path, $dir . $domain);
symlink($path, $dir . "www." . $domain);

setcookie("msg", "E09", time() + 60, "/");

header("Location: index.php");


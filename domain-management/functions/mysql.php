<?php

require_once(dirname(__FILE__) . "/../config.php");

try {
    $pdo = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

if (!isset($tablepre)) {
    $tablepre = "";
}

$t_users = $tablepre . "users";
$t_domains = $tablepre . "domains";

$tablepreValid = preg_match("#^[a-zA-Z0-9_]*$#", $tablepre);
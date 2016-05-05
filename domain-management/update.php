<?php
include("config.php");
include("functions/mysql.php");
include("functions/main.php");

// For version 1.4.* and lower //
$s = $pdo->prepare("SHOW COLUMNS FROM $t_users LIKE 'salt'");
$s->execute();

if ($s->rowCount() == 0) {
    $s = $pdo->prepare("ALTER TABLE $t_users ADD salt VARCHAR(256) NOT NULL AFTER password");
    $s->execute();
}

// Delete updatescript //
setcookie("update", "-1", 0, "/");

unlink("update.php");

header("Location: index.php");
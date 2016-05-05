<?php
require_once("main.php");

if (isset($_POST["pw"])) {
    echo makeHash($_POST["pw"]);
    exit;
}
?>

<form action="makehash.php" method="post">
    <input type="text" name="pw" required>
    <input type="submit"></input>
</form>
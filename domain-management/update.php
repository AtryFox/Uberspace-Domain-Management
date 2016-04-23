<?php
setcookie("update", "-1", 0, "/");

unlink("update.php");

header("Location: index.php");
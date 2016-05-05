<?php
setcookie("name", "", 0, "/");
setcookie("key", "", 0, "/");
setcookie("msg", "E08", time() + 60, "/");

header("Location: index.php");


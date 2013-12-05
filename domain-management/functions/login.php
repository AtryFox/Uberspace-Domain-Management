<?php
	include("../config.php");
	include("../functions/mysql.php");
	include("../functions/main.php");	
	
	
	$username = strtolower($_POST["username"]); 
	$salt = "";
	$q = mysql_query("SELECT salt FROM users WHERE username = '".mysql_real_escape_string($username)."'");
	echo mysql_error();
	while($r = mysql_fetch_array($q))
	{
		$salt = $r["salt"];
		echo $salt;
	}
	$password = makeSaltedHash($_POST["password"], $salt); 
		
		$q = mysql_query("SELECT password FROM users WHERE username = '".mysql_real_escape_string($username)."' AND password = '".mysql_real_escape_string($password)."'");
		 while($r = mysql_fetch_array($q)) {
		  setcookie("name", $username, time()+(3600*24*365), "/");
		  setcookie("key", $password, time()+(3600*24*365), "/");
		  setcookie("msg", "E00", time()+60, "/");
		  header("Location: ../index.php");
		  exit;
		 }
		setcookie("msg", "E01", time()+60, "/");
		header("Location: ../index.php");
		exit;
?>

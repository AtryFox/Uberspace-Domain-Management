<?php 
if(!isset($_GET["id"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

	$q = mysql_query("SELECT * FROM domains WHERE id = '".$_GET["id"]."';");
	while ($r = mysql_fetch_array($q)) {
		if(is_link($dir.$r["domain"])) {
			unlink($dir.$r["domain"]);
		}
		if( is_link($dir."www.".$r["domain"])) {
			unlink($dir."www.".$r["domain"]);
		}
		
		mysql_query("DELETE FROM domains WHERE id = '".$r["id"]."';");
	}

	setcookie("msg", "E07", time()+60, "/");
	header("Location: index.php");
	//echo mysql_error();
?>
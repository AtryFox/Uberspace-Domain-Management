<?php
	function getLoggedin() {
		if(isset($_COOKIE["name"])) {
			if (isset($_COOKIE["key"])) {
				$username = $_COOKIE["name"];
				$password = $_COOKIE["key"];
	
				$q = mysql_query("SELECT password FROM users WHERE username = '".mysql_real_escape_string($username)."' AND password = '".mysql_real_escape_string($password)."'");
				while($r = mysql_fetch_array($q)) {
					return TRUE;
				} return FALSE;
			} else return FALSE;
		} else return FALSE;
	}
	
	function makeHash($hashThis) {
		for($i = 0; $i < 42; $i++) $hashThis = hash("sha512", $hashThis);
		return $hashThis;
	}
	
	function checkDomain($domain) {
		$q = mysql_query("SELECT domain FROM domains WHERE domain = '".mysql_real_escape_string($domain)."'");
		while($r = mysql_fetch_array($q)) {
			return TRUE;
		} return FALSE;
	}
?>
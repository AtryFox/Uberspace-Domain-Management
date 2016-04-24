<?php

class Main {
	public function getName() {
		if(!isset($_COOKIE["name"])) return "";
		return $_COOKIE["name"];
	}

	public function getBaseDir() {
		global $dir;
		return $dir;
	}
}


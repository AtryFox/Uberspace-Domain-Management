<?php
require_once(__DIR__ . "/main.php");
require_once(__DIR__ . "/../functions/main.php");

class Domains extends Main
{
	public function __construct()
	{
		$this->domains = $this->getDomains();
		$this->domainsEmpty = count($this->domains) == 0 ? true : false;
	}

	public $domains = array();

	public $domainsEmpty;

	private function getDomains()
	{

		global $pdo, $t_domains;

		$o = "";
		if (isset($_GET["order"])) $o = strtolower($_GET["order"]);

		switch ($o) {
			case "id":
				$order = "id";
				break;
			default:
				$order = "domain";
				break;
		}

		$s = $pdo->prepare("SELECT * FROM $t_domains ORDER BY $order");
		$s->execute();

		$domains = $s->fetchAll();
		$output = array();
		
		
		foreach ($domains as $value) {
			array_push($output, new Domain($value["id"], $value["domain"]));
		}
		
		return $output;
	}
}

class Domain
{
	public function __construct($_id, $_domain)
	{
		global $dir;

		$this->id = $_id;
		$this->domain = $_domain;
		$this->path1 = $dir . $this->domain;
		$this->path2 = $dir . "www." . $this->domain;
		$this->path1Status = checkLink($this->path1, $this->id);
		$this->path2Status = checkLink($this->path2, $this->id);
		$this->realPath = getLink($this->path1, $this->path2);
		$this->realPathStatus = checkFolder(readlink($this->path1), readlink($this->path2));
	}

	public $id;
	public $domain;
	public $path1;
	public $path2;
	public $path1Status;
	public $path2Status;
	public $realPath;
	public $realPathStatus;

}
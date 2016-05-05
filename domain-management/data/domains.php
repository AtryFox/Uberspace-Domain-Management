<?php
require_once(__DIR__ . "/../functions/main.php");

class Domains
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

error_reporting(E_ALL);

class Domain
{
    

    public function __construct($_id, $_domain = null)
    {
        if ($_domain == null) $this->getDomainById($_id);
        else $this->loadValues($_id, $_domain);
    }

    private function getDomainById($_id)
    {
        global $pdo, $t_domains;

        $s = $pdo->prepare("SELECT * FROM $t_domains WHERE id = :id LIMIT 1");
        $s->execute(array('id' => $_id));

        if ($s->rowCount() == 0) return false;

        while ($r = $s->fetch()) {
            $this->loadValues($r["id"], $r["domain"]);
        }
    }

    private function loadValues($_id, $_domain)
    {
        global $dir;

        $this->id = $_id;
        $this->domain = $_domain;
        $this->path1 = $dir . $this->domain;
        $this->path2 = $dir . "www." . $this->domain;
        $this->path1Status = checkLink($this->path1, $this->id);
        $this->path2Status = checkLink($this->path2, $this->id);
        $this->realPath = getLink($this->path1, $this->path2);
        if(file_exists($this->path1))
            $this->shortPath = substr(str_replace($dir, "", readlink($this->path1)), 0, -1);
        else if (file_exists($this->path2))
            $this->shortPath = substr(str_replace($dir, "", readlink($this->path2)), 0, -1);
        else $this->shortPath = "";
            
    }

    public $id;
    public $domain;
    public $path1;
    public $path2;
    public $path1Status;
    public $path2Status;
    public $realPath;
    public $shortPath;

}
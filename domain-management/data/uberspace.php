<?php

require_once(__DIR__ . "/../functions/main.php");

class Uberspace
{
	public function __construct()
	{
		$this->domains = $this->getDomains();
		$this->domainsEmpty = count($this->domains) == 0 ? true : false;
		$this->mailDomains = $this->getMailDomains();
		$this->mailDomainsEmpty = count($this->mailDomains) == 0 ? true : false;
		$this->certificates = $this->getCertificates();
		$this->certificatesEmpty = count($this->certificates) == 0 ? true : false;
	}


	public $domains = array();

	public $domainsEmpty;

	private function getDomains()
	{
		exec('uberspace-list-domains -w', $result);

		$output = array();

		foreach ($result as $domain) {
			array_push($output, array('name' => $domain));
		}

		return $output;
	}


	public $mailDomains = array();

	public $mailDomainsEmpty;

	private function getMailDomains()
	{
		exec('uberspace-list-domains -m', $result);

		$output = array();

		foreach ($result as $domain) {
			$domain = explode(" ", $domain);
			array_push($output, array('name' => $domain[0], 'namespace' => $domain[1]));
		}

		$this->domainsEmpty = count($output) == 0 ? true : false;

		return $output;
	}


	public $certificates = array();

	public $certificatesEmpty;

	private function getCertificates()
	{
		exec('uberspace-list-certificates', $result);

		$output = array();
		$current = 0;

		foreach ($result as $certificate) {

			if (empty($certificate)) {
				$current++;
				continue;
			}

			if (preg_match("/common name: (.*)/", $certificate, $matches)) {
				$output[$current]->name = "";
				$output[$current]->name = $matches[1];
				continue;
			}

			if (preg_match("/issuer: (.*)/", $certificate, $matches)) {
				$output[$current]->issuer = $matches[1];
				continue;
			}

			if (preg_match("/valid until: (.*) ([a-zA-Z]+)/", $certificate, $matches)) {
				$date = date("d.m.Y H:i:s", strtotime($matches[1]));

				$output[$current]->validUntil = $date . " " . $matches[2];
				continue;
			}

			if (preg_match("/will be removed in ([0-9]+) days./", $certificate, $matches)) {
				$output[$current]->removedIn = $matches[1];
				continue;
			}

			if (preg_match("/alternative name: (.*)/", $certificate, $matches)) {
				if (!isset($output[$current]->alternatives)) {
					$output[$current]->alternatives = array();
				}

				array_push($output[$current]->alternatives, array('name' => $matches[1]));
				continue;
			}

		}

		return $output;
	}
}
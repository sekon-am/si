<?php
class Stats extends Auth {
	private $stats;
	public function __construct() {
		parent::__construct();
		$this->stats = new StatsModel();
	}
	public function index() {
		$this->checkUI();
		$view = new StatsView(
			array(
				'hosts' => $this->stats->hosts(),
				'byCountry' => $this->stats->hostsByCountry(),
				'byPort' => $this->stats->hostsBy('port'),
				'byMalware' => $this->stats->hostsBy('malware'),
			)
		);
		$view->display();
	}
}
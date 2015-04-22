<?php
class WareLog extends Ctrl {
	private $model;
	public function __construct() {
		parent::__construct();
		$this->model = new WareLogModel();
	}
	public function pages() {
		$pages = array();
		$ip = Input::get('ip_filter');
		$domain = Input::get('domain_filter');
		$malware = Input::get('malware_filter');
		$rowsAmount = $this->model->rowsAmount($ip,$domain,$malware);
		$pagesAmount = ceil($rowsAmount / Config::SETS_PER_PAGE);
		$obj->pages_amount = $pagesAmount;
		$obj->rows_per_page = Config::SETS_PER_PAGE;
		echo json_encode($obj);
	}
	public function data() {
		$from = intval( Input::get('from') )*Config::SETS_PER_PAGE;
		$ip = Input::get('ip_filter');
		$domain = Input::get('domain_filter');
		$malware = Input::get('malware_filter');
		$data = $this->model->sliceData( $from,$ip,$domain,$malware );
		echo json_encode( $data );
	}
	public function index() {
		$view = new WareLogView();
		$view->display();
	}
}
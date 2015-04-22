<?php
class WareLog extends Ctrl {
	private $model;
	public function __construct($authCheck = true) {
		parent::__construct();
		$this->model = new WareLogModel();
		$this->auth = new Auth();
	}
	public function pages() {
		$this->auth->check();
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
		$this->auth->check();
		$from = intval( Input::get('from') )*Config::SETS_PER_PAGE;
		$ip = Input::get('ip_filter');
		$domain = Input::get('domain_filter');
		$malware = Input::get('malware_filter');
		$format = Input::get('format');
		$data = $this->model->sliceData( $from,$ip,$domain,$malware );
		switch($format){
			case 'txt':
				$txt = '';
				foreach($data as $row){
					$txt .= implode(',',(array)$row) . "\n";
				}
				Response::text($txt);
				break;
			case 'xml':
				Response::xml($data);
				break;
			case 'json':
			default:
				Response::json($data);
		}
	}
	public function index() {
		$this->auth->checkUI();
		$view = new WareLogView();
		$view->display();
	}
}
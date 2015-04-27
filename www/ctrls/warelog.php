<?php
class WareLog extends Ctrl {
	private $model;
	protected $auth;
	private $params;
	public function __construct() {
		parent::__construct();
		$this->model = new WareLogModel();
		$this->auth = new Auth();
		$this->params = array();
	}
	private function getParams() {
		$this->params['ip'] = Input::get('ip_filter');
		$this->params['domain'] = Input::get('domain_filter');
		$this->params['malware'] = Input::get('malware_filter');
		if($cidr = Input::get('cidr')){
			$ips = Ip::cidr2range($cidr);
			$this->params['ip_start'] = $ips->ip_start;
			$this->params['ip_finish'] = $ips->ip_finish;
		}else{
			$this->params['ip_start'] = Input::get('ip_start');
			$this->params['ip_finish'] = Input::get('ip_finish');
		}
	}
	public function pages() {
		$this->auth->check();
		$this->getParams();
		$rowsAmount = $this->model->rowsAmount(
			$this->params['ip'],
			$this->params['domain'],
			$this->params['malware'],
			$this->params['ip_start'],
			$this->params['ip_finish']
		);
		echo json_encode(
			new Obj(
				array(
					'pages_amount' => ceil($rowsAmount / Config::SETS_PER_PAGE),
					'rows_per_page' => Config::SETS_PER_PAGE,
				)
			)
		);
	}
	public function data() {
		$this->auth->check();
		$this->getParams();
		if($format = Input::get('format')){
			set_time_limit(0);
			$rowsAmount = $this->model->rowsAmount(
				$this->params['ip'],
				$this->params['domain'],
				$this->params['malware'],
				$this->params['ip_start'],
				$this->params['ip_finish']
			);
			for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
				$data = $this->model->sliceData( 
					$from,
					$this->params['ip'],
					$this->params['domain'],
					$this->params['malware'],
					$this->params['ip_start'],
					$this->params['ip_finish'],
					Config::ROWS_FORMAT 
				);
				switch($format){
					case 'txt':
						$txt = '';
						foreach($data as $row){
							$txt .= implode(',',(array)$row) . "\n";
						}
						Response::text($txt);
						break;
					case 'cc':
						$txt = '';
						foreach($data as $row)if($row->ip2){
							$txt .= $row->ip2 . "\n";
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
		}else{
			Response::json(
				$this->model->sliceData( 
					intval( Input::get('from') )*Config::SETS_PER_PAGE,
					$this->params['ip'],
					$this->params['domain'],
					$this->params['malware'],
					$this->params['ip_start'],
					$this->params['ip_finish']
				)
			);
		}
	}
	public function index() {
		$this->auth->checkUI();
		$view = new WareLogView();
		$view->display();
	}
	public function cidr2range() {
		Response::json(
			Ip::cidr2range( 
				Input::get('cidr') 
			)
		);
	}
}
<?php
class Proxy extends Ctrl {
	private $model;
	private $auth;
	private $params;
	public function __construct() {
		parent::__construct();
		$this->model = new ProxyModel();
		$this->auth = new Auth();
		$this->params = array();
	}
	private function getSearchParams() {
		$this->params['ip_filter'] = Input::get('ip_filter');
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
		$this->getSearchParams();
		$rowsAmount = $this->model->rowsAmount(
			$this->params['ip_filter'],
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
		$this->getSearchParams();
		if($format = Input::get('format')){
			set_time_limit(0);
			$rowsAmount = $this->model->rowsAmount(
				$this->params['ip_filter'],
				$this->params['ip_start'],
				$this->params['ip_finish']
			);
			for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
				$data = $this->model->sliceData( 
					$from,
					$this->params['ip_filter'],
					$this->params['ip_start'],
					$this->params['ip_finish'],
					Config::ROWS_FORMAT 
				);
				foreach($data as $el){
					unset($el->id);
					unset($el->num);
				}
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
					$this->params['ip_filter'],
					$this->params['ip_start'],
					$this->params['ip_finish'],
					Config::SETS_PER_PAGE
				)
			);
		}
	}
	public function index() {
		$this->auth->checkUI();
		$view = new ProxyView();
		$view->display();
	}
	private function addLn($ln) {
		if( ($ln = trim($ln)) && ($ln{0} != '#') ) {
			$this->model->add(explode(':',$ln));
		}
	}
	function import() {
		set_time_limit(0);
		$res = null;
		foreach($_FILES as $file){
			move_uploaded_file($file['tmp_name'],$file['name']);
			$fname = $file['name'];
			$f = fopen($fname, 'r');
			$str = '';
			$amount = 0;
			while(!feof($f)){
				$str .= fread($f,100000);
				$lns = explode("\n",$str);
				$amount += count($lns);
				$str = array_pop($lns);
				foreach($lns as $ln){
					$this->addLn($ln);
				}
				$this->model->submitAdd();
			}
			fclose($f);
			unlink($fname);
			$obj = null;
			$obj->fname = $fname;
			$obj->amount = $amount;
			$res->files []= $obj;
		}
		Response::json($res);
	}
}
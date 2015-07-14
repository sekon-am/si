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
                $this->params['country'] = Input::get('country');
	}
	public function pages() {
		$this->auth->check();
		$this->getParams();
		$rowsAmount = $this->model->rowsAmount(
			$this->params['ip'],
			$this->params['domain'],
			$this->params['malware'],
			$this->params['ip_start'],
			$this->params['ip_finish'],
			$this->params['country']
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
	private function sliceData($from) {
		return $this->model->sliceData( 
			$from,
			$this->params['ip'],
			$this->params['domain'],
			$this->params['malware'],
			$this->params['ip_start'],
			$this->params['ip_finish'],
			Config::ROWS_FORMAT,
			$this->params['country']
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
				$this->params['ip_finish'],
                                $this->params['country']
			);
			switch($format){
				case 'txt':
					header('Content-Type: text/plain');
					for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
						$data = $this->sliceData($from);
						foreach($data as $row){
							echo implode(',',(array)$row) . "\n";
						}
					}
					break;
				case 'cc':
					header('Content-Type: text/plain');
					for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
						$data = $this->sliceData($from);
						$dataCC = array();
						foreach($data as $row)if($row->ip2){
							$dataCC[ $row->ip2 ] = $row->method;
						}
						$txt = '';
						foreach($dataCC as $key => $val) {
							$txt .= $key.','.$val."\n";
						}
						echo $txt;
					}
					break;
				case 'xml':
					header('Content-Type: application/xhtml+xml');
					echo "<?xml version=\"1.0\"?>\n<security_feed>\n";
					for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
						$data = $this->sliceData($from);
						foreach($data as $el){
							echo "\t<entry>\n";
							foreach( $el as $key => $val ){
								echo "\t\t<{$key}>{$val}</{$key}>\n";
							}
							echo "\t</entry>\n";
						}
					}
					echo '</security_feed>'."\n";
					break;
				case 'json':
				default:
					header('Content-type: application/json');
					echo '[';
					$first = true;
					for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
						$data = $this->sliceData($from);
						foreach($data as $el){
							if($first){
								$first = false;
							}else{
								echo ',';
							}
							echo json_encode($el);
						}
					}
					echo ']';
			}
		}else{
			Response::json(
				$this->model->sliceData( 
					intval( Input::get('from') )*Config::SETS_PER_PAGE,
					$this->params['ip'],
					$this->params['domain'],
					$this->params['malware'],
					$this->params['ip_start'],
					$this->params['ip_finish'],
                                        Config::SETS_PER_PAGE,
                                        $this->params['country']
				)
			);
		}
	}
	public function index() {
		$this->auth->checkUI();
		$view = new WareLogView();
                $view->country = Input::get('country');
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
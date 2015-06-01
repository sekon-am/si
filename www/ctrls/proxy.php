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
	private function sliceData($from) {
		return $this->model->sliceData( 
			$from,
			$this->params['ip_filter'],
			$this->params['ip_start'],
			$this->params['ip_finish'],
			Config::ROWS_FORMAT
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
			switch($format){
				case 'txt':
					header('Content-Type: text/plain');
					for( $from = 0; $from < $rowsAmount; $from += Config::ROWS_FORMAT ){
						$data = $this->sliceData($from);
						foreach($data as $row){
							unset($row->id);
							unset($row->num);
							echo implode(':',(array)$row) . "\n";
						}
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
							unset($el->id);
							unset($el->num);
							echo json_encode($el);
						}
					}
					echo ']';
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
			$amount = 0;
			$fname = '/data/'.$file['name'];
			move_uploaded_file($file['tmp_name'],$fname);
			if($f = fopen($fname, 'r')){
				$str = '';
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
			}
			$obj = null;
			$obj->fname = $fname;
			$obj->amount = $amount;
			$res->files []= $obj;
		}
		Response::json($res);
	}
}
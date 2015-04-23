<?php
class Proxy extends Ctrl {
	private $model;
	private $auth;
	public function __construct() {
		parent::__construct();
		$this->model = new ProxyModel();
		$this->auth = new Auth();
	}
	public function pages() {
		$this->auth->check();
		$pages = array();
		$rowsAmount = $this->model->rowsAmount();
		$pagesAmount = ceil($rowsAmount / Config::SETS_PER_PAGE);
		$obj = null;
		$obj->pages_amount = $pagesAmount;
		$obj->rows_per_page = Config::SETS_PER_PAGE;
		Response::json($obj);
	}
	public function data() {
		$this->auth->check();
		$from = intval( Input::get('from') )*Config::SETS_PER_PAGE;
		$format = Input::get('format');
		$data = $this->model->sliceData( $from );
		if($format){
			foreach($data as $el){
				unset($el->id);
				unset($el->num);
			}
		}
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
		$view = new ProxyView();
		$view->display();
	}
	private function addLn($ln) {
		if( ($ln = trim($ln)) && ($ln{0} != '#') ) {
			$this->model->add(explode(',',$ln));
		}
	}
	function import() {
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
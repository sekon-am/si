<?php
class Sfpctrl {
	private $model;
	function __construct() {
		$this->model = new Sfpmodel();
	}
	private function addLn($ln) {
		if(($ln=trim($ln)) && ($ln{0}!='#')){
			$this->model->add(explode(',',$ln));
		}
	}
	function import() {
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
			$this->addLn($str);
			$this->model->submitAdd();
			fclose($f);
			unlink($fname);
		}
	}
	function pages() {
		$pages = array();
		$rowsAmount = $this->model->rowsAmount();
		$pagesAmount = ceil($rowsAmount / Config::SETS_PER_PAGE);
		$obj->pages_amount = $pagesAmount;
		$obj->rows_per_page = Config::SETS_PER_PAGE;
		echo json_encode($obj);
	}
	function data() {
		$from = intval( Input::get('from') )*Config::SETS_PER_PAGE;
		$data = $this->model->sliceData( $from );
		echo json_encode( $data );
	}
}
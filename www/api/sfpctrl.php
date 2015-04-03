<?php
class Sfpctrl {
	var $model;
	function __construct() {
		$this->model = new Sfpmodel();
	}
	function import() {
		foreach($_FILES as $file){
			$fname = $file['tmp_name'];
			$f = fopen($fname, 'r');
			$str = '';
			$amount = 0;
			while(!feof($f)){
				$str .= fread($f,10000);
				$lns = explode("\n",$str);
				$amount += count($lns);
				$str = array_pop($lns);
				foreach($lns as $ln){
					if(($ln=trim($ln)) && ($ln{0}!='#')){
						$ins = $this->model->add(explode(',',$ln));
					}
				}
			}
			fclose($f);
			Log::write($file['name']."\t".$amount);
		}
	}
}
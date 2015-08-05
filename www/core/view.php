<?php
abstract class View {
	protected $data;
	public function __construct($params=array()){
		$this->data = $params;
	}
	public function __get($name) {
		return array_key_exists( $name, $this->data ) ? $this->data[$name] : null;
	}
	public function __set($name,$value) {
		$this->data[$name] = $value;
	}
	private function getTplDir() {
		return 'tpls/' . Config::$default['tpl'] . '/';
	}
	public function printTplDir() {
		echo $this->getTplDir();
	}
	protected function loadTpl($name) {
		$fname = $this->getTplDir() . strtolower($name) . '.php';
		if(file_exists($fname)){
			ob_start();
			include($fname);
			$output = ob_get_clean();
			return $output;
		}else{
			die("Can't find tpl {$fname}");
		}
	}
	abstract public function toString();
	public function display() {
		echo $this->toString();
	}
}
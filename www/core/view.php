<?php
abstract class View {
	protected $data;
	public function __construct($params=array()){
		$this->data = $params;
	}
	public function __get($name) {
		if( array_key_exists( $name, $this->data ) ) {
			return $this->data[$name];
		}else{
			$view = get_class();
			die("Can't find field {$name} in view {$view}");
		}
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
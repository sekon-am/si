<?php
class Obj {
	public function __construct($array = array()){
		if(count($array))
			foreach($array as $key => $val){
				$this->$key = $val;
			}
	}
}
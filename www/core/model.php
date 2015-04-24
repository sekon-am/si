<?php
class Model {
	protected $db;
	public function __construct() {
		$this->db = new mysqli(Config::DB_HOST,Config::DB_USER,Config::DB_PASS,Config::DB_NAME);
		if( $this->db->connect_errno ){
			die("Can't connect to database: (" . $this->db->connect_errno . ") " . $this->db->connect_error);
		}		
	}
	public function __destruct() {
		$this->db->close();
	}
	protected function query($sql) {
		$res = $this->db->query($sql);
		if($res===FALSE){
			$this->db->close();
			die("Wrong SQL: {$sql}");
		}else{
			$ret = TRUE;
			if($res!==TRUE){
				for($el = $res->fetch_object(), $ret = array(); $el != NULL; $el = $res->fetch_object()){
					$ret []= $el;
				}
				$res->close();
			}
			return $ret;
		}
	}
	protected function affected_rows() {
		return $this->db->affected_rows;
	}
}
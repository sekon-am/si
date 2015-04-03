<?php
class Sfpmodel {
	private $db;
	public function __construct($db_host='localhost',$db_user='root',$db_pass='',$db_name='test') {
		$this->db = new mysqli($db_host,$db_user,$db_pass,$db_name);
		if($err = $this->db->connect_error){
			die($err);
		}
	}
	public function __destruct() {
		$this->db->close();
	}
	private function _query($sql) {
		$res = $this->db->query($sql);
		if($res===FALSE){
			$this->db->close();
			die("Wrong SQL: {$sql}");
		}else{
			$ret = TRUE;
			if($res!==TRUE){
				$ret = $res->fetch_fields();
				$res->close();
			}
			return $ret;
		}
	}
	public function add($params) {
		$params[6] = date('Y-m-d H:i:s',$params[6]);
		Log::write($params[6]);
		$sql = "INSERT INTO sfp (ip,asum,routing_aggregate,country,domain,state,t,diagnostic) VALUES ('".implode("','",array_slice($params,0,8))."')";
		return $this->_query($sql);
	}
}
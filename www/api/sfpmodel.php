<?php
class Sfpmodel {
	private $db;
	private $dataAdd;
	public function __construct($db_host=null,$db_user=null,$db_pass=null,$db_name=null) {
		session_start();
		if($db_host===null)$db_host=Config::DB_HOST;
		if($db_user===null)$db_user=Config::DB_USER;
		if($db_pass===null)$db_pass=Config::DB_PASS;
		if($db_name===null)$db_name=Config::DB_NAME;
		$this->db = new mysqli($db_host,$db_user,$db_pass,$db_name);
		if($err = $this->db->connect_error){
			die($err);
		}
		$this->dataAdd = '';
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
				for($el = $res->fetch_object(), $ret = array(); $el != NULL; $el = $res->fetch_object()){
					$ret []= $el;
				}
				$res->close();
			}
			return $ret;
		}
	}
	public function add($params) {
		$params[6] = date('Y-m-d H:i:s',$params[6]);
		if($this->dataAdd){
			$this->dataAdd .= ',';
		}
		$this->dataAdd .= "('".implode("','",array_slice($params,0,8))."')";
	}
	public function submitAdd() {
		if($this->dataAdd){
			$sql = "INSERT INTO sfp (ip,asum,routing_aggregate,country,domain,state,t,diagnostic) VALUES ".$this->dataAdd;
			$this->dataAdd = '';
			return $this->_query($sql);
		}
		return null;
	}
	public function rowsAmount($ip='',$domain='',$malware='') {
		$sql = "SELECT COUNT(*) as `amount` FROM sfp WHERE 1";
		if($ip) {
			$sql .= ' AND (ip LIKE "'.$ip.'%")';
		}
		if($domain) {
			$sql .= ' AND (domain LIKE "'.$domain.'%")';
		}
		if($malware) {
			$sql .= ' AND (diagnostic LIKE "'.$malware.'%")';
		}
		$res = $this->_query($sql);
		return $res[0]->amount;
	}
	public function sliceData($from,$ip='',$domain='',$malware='') {
		$sql = "SELECT * FROM sfp WHERE 1";
		if($ip) $sql .= ' AND (ip LIKE "'.$ip.'%")';
		if($domain) $sql .= ' AND (domain LIKE "'.$domain.'%")';
		if($malware) $sql .= ' AND (diagnostic LIKE "'.$malware.'%")';
		Log::write($sql);
		$data = $this->_query($sql . " LIMIT {$from}," . Config::SETS_PER_PAGE);
		$i = 1;
		foreach($data as &$el){
			$el->num = $from + $i++;
			$diagnostic = preg_split('~\s+~',$el->diagnostic);
			$el->method = $diagnostic[0];
			$el->ip1 = $diagnostic[1];
			$el->port = $diagnostic[2];
			$el->ip2 = (count($diagnostic)>3)?$diagnostic[3]:'';
		}
		return $data;
	}
}
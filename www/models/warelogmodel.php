<?php
class WareLogModel extends Model {
	private $dataAdd;
	public function __construct() {
		parent::__construct();
		session_start();
		$this->dataAdd = '';
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
		$res = $this->query($sql);
		return $res[0]->amount;
	}
	public function sliceData($from,$ip='',$domain='',$malware='') {
		$sql = "SELECT * FROM sfp WHERE 1";
		if($ip) $sql .= ' AND (ip LIKE "'.$ip.'%")';
		if($domain) $sql .= ' AND (domain LIKE "'.$domain.'%")';
		if($malware) $sql .= ' AND (diagnostic LIKE "'.$malware.'%")';
		$data = $this->query($sql . " LIMIT {$from}," . Config::SETS_PER_PAGE);
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
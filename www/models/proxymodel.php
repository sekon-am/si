<?php
class ProxyModel extends Model {
	private $dataAdd;
	public function __construct() {
		parent::__construct();
		$this->dataAdd = '';
	}
	public function rowsAmount() {
		$sql = "SELECT COUNT(*) as `amount` FROM proxies WHERE 1";
		$res = $this->query($sql);
		return $res[0]->amount;
	}
	public function sliceData($from) {
		$sql = "SELECT * FROM proxies WHERE 1";
		$data = $this->query($sql . " LIMIT {$from}," . Config::SETS_PER_PAGE);
		$i = 1;
		foreach($data as &$el){
			$el->num = $from + $i++;
		}
		return $data;
	}
	public function add($params) {
		if($this->dataAdd){
			$this->dataAdd .= ',';
		}
		$this->dataAdd .= "('".implode("','",array_slice($params,0,3))."')";
	}
	public function submitAdd() {
		if($this->dataAdd){
			$sql = "INSERT INTO proxies (ip,port,srv) VALUES ".$this->dataAdd;
			$this->dataAdd = '';
			return $this->query($sql);
		}
		return null;
	}
}
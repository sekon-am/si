<?php
class ProxyModel extends Model {
	private $dataAdd;
	public function __construct() {
		parent::__construct();
		$this->dataAdd = '';
	}
	private function buildWhere($ip_filter,$ip_start,$ip_finish) {
		$where = 'WHERE 1';
		if( $ip_filter ){
			Ip::long($ip_filter);
			$where .= " AND (ip LIKE '{$ip_filter}%')";
		}
		if( $ip_start ){
			Ip::long($ip_start);
			$where .= " AND ('{$ip_start}' <= ip)";
		}
		if( $ip_finish ){
			Ip::long($ip_finish);
			$where .= " AND (ip <= '{$ip_finish}')";
		}
		return $where;
	}
	public function rowsAmount($ip_filter,$ip_start,$ip_finish) {
		$res = $this->query("SELECT COUNT(*) as `amount` FROM proxies " . $this->buildWhere($ip_filter,$ip_start,$ip_finish));
		return $res[0]->amount;
	}
	public function sliceData($from,$ip_filter,$ip_start,$ip_finish,$limit=0) {
		$sql = "SELECT * FROM proxies " . $this->buildWhere($ip_filter,$ip_start,$ip_finish);
		if($limit){
			$sql .= " LIMIT {$from}, {$limit}";
		}
		$data = $this->query($sql);
		$i = 1;
		foreach($data as &$el){
			$el->num = $from + $i++;
			Ip::short( $el->ip );
		}
		return $data;
	}
	public function add($params) {
		if(Ip::is($params[0])) {
			Ip::long( $params[0] );
		}
		if($this->dataAdd){
			$this->dataAdd .= ',';
		}
		$this->dataAdd .= "('".implode("','",array_slice($params,0,3))."')";
	}
	public function submitAdd() {
		if($this->dataAdd){
			$this->query("INSERT INTO proxies (ip,port,srv) VALUES ".$this->dataAdd);
			$this->dataAdd = '';
			return $this->affected_rows();
		}
		return null;
	}
}
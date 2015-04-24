<?php
class WareLogModel extends Model {
	public function rowsAmount($ip='',$domain='',$malware='',$ip_start='',$ip_finish='') {
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
		if($ip_start) {
			$sql .= " AND ('{$ip_start}' <= ip)";
		}
		if($ip_finish) {
			$sql .= " AND (ip <= '{$ip_finish}')";
		}
		$res = $this->query($sql);
		return $res[0]->amount;
	}
	public function sliceData($from,$ip='',$domain='',$malware='',$ip_start='',$ip_finish='',$is_limited=TRUE) {
		$sql = "SELECT * FROM sfp WHERE 1";
		if($ip) $sql .= ' AND (ip LIKE "'.$ip.'%")';
		if($domain) $sql .= ' AND (domain LIKE "'.$domain.'%")';
		if($malware) $sql .= ' AND (diagnostic LIKE "'.$malware.'%")';
		if($ip_start) {
			$sql .= " AND ('{$ip_start}' <= ip)";
		}
		if($ip_finish) {
			$sql .= " AND (ip <= '{$ip_finish}')";
		}
		if($is_limited){
			$sql .= " LIMIT {$from}," . Config::SETS_PER_PAGE;
		}else{
			set_time_limit(0);
		}
		$data = $this->query($sql);
		$i = 1;
		foreach($data as &$el){
			$el->num = $from + $i++;
			$diagnostic = preg_split('~\s+~',$el->diagnostic);
			$el->method = $diagnostic[0];
			$el->ip1 = $diagnostic[1];
			$el->port = $diagnostic[2];
			$el->ip2 = (count($diagnostic)>3)?$diagnostic[3]:'';
			unset($el->diagnostic);
		}
		return $data;
	}
}
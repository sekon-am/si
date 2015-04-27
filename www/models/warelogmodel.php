<?php
class WareLogModel extends Model {
	private function prepareIp($ip) {
		$sections = array();
		foreach( explode( '.', trim( $ip, '.' ) ) as $sec ) {
			$sections []= substr( '000'.$sec, -3 ); 
		}
		return implode( '.', $sections );
	}
	private function makeWhere($ip='',$domain='',$malware='',$ip_start='',$ip_finish='') {
		$sql = " WHERE 1";
		if($ip) {
			$sql .= ' AND (ip LIKE "'.$this->prepareIp($ip).'%")';
		}
		if($domain) {
			$sql .= ' AND (domain LIKE "'.$domain.'%")';
		}
		if($malware) {
			$sql .= ' AND (diagnostic LIKE "'.$malware.'%")';
		}
		if($ip_start) {
			$sql .= " AND ('".$this->prepareIp($ip_start)."' <= ip)";
		}
		if($ip_finish) {
			$sql .= " AND (ip <= '".$this->prepareIp($ip_finish)."')";
		}
		return $sql;
	}
	private function prepareRow( &$el, $num ) {
		$el->ip = substr( preg_replace( '~\.0{1,2}~i', '.', '.'.$el->ip ), 1 );
		$el->num = $num;
		$diagnostic = preg_split('~\s+~',$el->diagnostic);
		$el->method = $diagnostic[0];
		$el->ip1 = $diagnostic[1];
		$el->port = $diagnostic[2];
		$el->ip2 = (count($diagnostic)>3)?$diagnostic[3]:'';
		unset($el->diagnostic);
	}
	public function rowsAmount($ip='',$domain='',$malware='',$ip_start='',$ip_finish='') {
		$sql = "SELECT COUNT(*) as `amount` FROM sfp" . $this->makeWhere($ip,$domain,$malware,$ip_start,$ip_finish);
		$res = $this->query($sql);
		return $res[0]->amount;
	}
	public function sliceData($from,$ip='',$domain='',$malware='',$ip_start='',$ip_finish='',$limit=0) {
		$sql = "SELECT * FROM sfp" . $this->makeWhere($ip,$domain,$malware,$ip_start,$ip_finish);
		if( !$limit ) $limit = Config::SETS_PER_PAGE;
		$sql .= " LIMIT {$from}," . $limit;
		$data = $this->query($sql);
		$i = 1;
		foreach($data as &$el){
			$this->prepareRow($el,$from + $i++);
		}
		return $data;
	}
}
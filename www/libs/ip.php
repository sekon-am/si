<?php 
class Ip {
	public static function long(&$ip) {
		$sections = array();
		foreach( explode( '.', trim( $ip, '.' ) ) as $sec ) {
			$sections []= substr( '000'.$sec, -3 ); 
		}
		$ip = implode( '.', $sections );
		return $ip;
	}
	public static function short(&$ip) {
		$ip = substr( preg_replace( '~\.0+(\d)~i', '.$1', '.'.$ip ), 1 );
		return $ip;
	}
	public static function is($ip) {
		return preg_match('~\d{1,3}(\.\d{1,3}){3,3}~i',$ip);
	}
	public static function cidr2range($cidr) {
		list($ip,$mask) = explode('/',$cidr);
		$blocks = explode('.',$ip);
		$bin = '';
		foreach($blocks as $block){
			$bin .= substr('00000000'.decbin($block),-8);
		}
		$bin = substr( $bin . '00000000000000000000000000000000', 0, intval(trim($mask)) );
		$start = substr( $bin . '00000000000000000000000000000000', 0, 32 );
		$finish = substr( $bin . '11111111111111111111111111111111', 0, 32 );
		function ip_bin2dec($bin) {
			$ip = '';
			for($i=0;$i<32;$i+=8){
				$ip .= bindec( substr($bin,$i,8) ) . '.';
			}
			return substr($ip,0,-1);
		}
		return new Obj(
			array(
				'ip_start' => ip_bin2dec($start),
				'ip_finish' => ip_bin2dec($finish),
			)
		);
	}
}
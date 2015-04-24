<?php
class SubscribeModel extends Model {
	private function getCurrentUser() {
		$authModel = new AuthModel();
		return $authModel->getCurrent();
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
	public function add($ip_start,$ip_finish) {
		$user_id = $this->getCurrentUser()->id;
		$this->query("INSERT INTO subscription (user_id, ip_start, ip_finish) VALUES ('{$user_id}','{$ip_start}','{$ip_finish}')");
		return $this->insert_id();
	}
	public function del($id) {
		$this->query("DELETE FROM subscription WHERE id='{$id}'");
		return $this->affected_rows();
	}
	public function get($id) {
		$subscrs = $this->query("SELECT * FROM subscription WHERE id='{$id}'");
		if(count($subscrs)){
			return $subscrs[0];
		}
		return null;
	}
	public function lst() {
		$user_id = $this->getCurrentUser()->id;
		return $this->query("SELECT * FROM subscription WHERE user_id='{$user_id}'");
	}
}
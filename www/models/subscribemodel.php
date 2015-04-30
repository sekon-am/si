<?php
class SubscribeModel extends Model {
	private function getCurrentUser() {
		$authModel = new AuthModel();
		return $authModel->getCurrent();
	}
	public function add($ip_start,$ip_finish) {
		$user_id = $this->getCurrentUser()->id;
		if( count( $this->query("SELECT * FROM subscription WHERE (user_id='{$user_id}') AND (ip_start='{$ip_start}') AND (ip_finish='{$ip_finish}')") ) ) {
			return 0;
		}else{
			$this->query("INSERT INTO subscription (user_id, ip_start, ip_finish) VALUES ('{$user_id}','{$ip_start}','{$ip_finish}')");
			return $this->insert_id();
		}
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
<?php
class UsersModel extends Model {
	public function lst() {
		return $this->query("SELECT * FROM users");
	}
	private function mkhash() {
		$letters = "abcdefghijklmnopqrstuvwxyz";
		$symbs = "0123456789".$letters.strtoupper($letters);
		$str = '';
		for($i=0;$i<Config::USER_HASH_LENGTH;$i++){
			$str .= $symbs{mt_rand(0,strlen($symbs)-1)};
		}
		return $str;
	}
	public function add($login,$email,$pass) {
		$hash = $this->mkhash();
		$pass = md5($pass);
		$this->query("INSERT INTO users (email,login,pass,hash) VALUES ('{$email}','{$login}','{$pass}','{$hash}')");
		return $this->insert_id();
	}
	public function del($id) {
		$this->query("DELETE FROM users WHERE id='{$id}'");
		return $this->affected_rows();
	}
	public function get($id) {
		return $this->query("SELECT * FROM users WHERE id='{$id}'");
	}
}
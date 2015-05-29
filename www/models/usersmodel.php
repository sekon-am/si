<?php
class UsersModel extends Model {
	public function lst() {
		return $this->query("SELECT * FROM users");
	}
	private function mkhash() {
		return Str::rand( Config::USER_HASH_LENGTH );
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
	public function chpass($login,$pass) {
		$this->query("UPDATE users SET pass='" . md5($pass) . "' WHERE login = '{$login}'");
		return $this->affected_rows();
	}
}
<?php
class AuthModel extends Model {
	public function __construct() {
		parent::__construct();
		session_start();
	}
	public function login($login,$pass) {
		$pass = md5($pass);
		$users = $this->query("SELECT * FROM users WHERE (login='{$login}') AND (pass='{$pass}')");
		$res = null;
		if(count($users)){
			$res = $users[0];
			$_SESSION['login'] = $res->login;
			$_SESSION['hash'] = $res->hash;
		}
		return $res;
	}
	public function logout() {
		unset($_SESSION['login']);
		unset($_SESSION['hash']);
	}
	public function check() {
		if($hash = Input::request('hash')){
			if( ! count( $this->query("SELECT * FROM users WHERE hash='{$hash}'") ) ){
				unset($hash);
			}
		}
		return (isset($_SESSION['hash']) || $hash) ? TRUE : FALSE;
	}
}
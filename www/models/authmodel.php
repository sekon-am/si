<?php
class AuthModel extends AbstractAuthModel {
	public function __construct() {
		parent::__construct();
		$this->loginJs = 'login';
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
	public function getCurrent() {
		if(isset($_SESSION['hash'])){
			$hash = $_SESSION['hash'];
			$users = $this->query("SELECT * FROM users WHERE hash='{$hash}'");
			return $users[0];
		}
		return null;
	}
	public function getCurrentHash() {
		if(isset($_SESSION['hash'])){
			return $_SESSION['hash'];
		}
		return null;
	}
	public function getCurrentLogin() {
		return Input::session('login');
	}
	public function isadmin() {
		return false;
	}
	public function recovery($login,$email) {
		$newpass = Str::rand(10);
		$this->query("UPDATE users SET pass='".md5($newpass)."' WHERE (login='{$login}') OR (email='{$email}')");
		if( $this->affected_rows() ) {
			$arr = $this->query("SELECT login,email FROM users WHERE (login='{$login}') OR (email='{$email}')");
			$usr = $arr[0];
			return new Obj(array(
				'pass' => $newpass,
				'login' => $usr->login,
				'email' => $usr->email,
			));
		}
		return null;
	}
}
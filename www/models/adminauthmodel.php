<?php
class AdminAuthModel extends AbstractAuthModel {
	public function __construct() {
		parent::__construct();
		$this->loginJs = 'adminlogin';
	}
	public function login($login,$pass) {
		if ( ( $login === Config::ADMIN_LOGIN ) && ( md5($pass) === Config::ADMIN_PASS ) ){
			$_SESSION['admin'] = true;
			return true;
		}
		return false;
	}
	public function logout() {
		unset($_SESSION['admin']);
	}
	public function check() {
		return isset($_SESSION['admin']);
	}
	public function isadmin() {
		return true;
	}
}
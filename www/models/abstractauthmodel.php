<?php
abstract class AbstractAuthModel extends Model {
	protected $loginJs;
	public function __construct() {
		parent::__construct();
		session_start();
	}
	public function getLoginJs() {
		return $this->loginJs;
	}
	abstract public function login($login,$pass);
	abstract public function logout();
	abstract public function check();
	abstract public function isadmin();
}
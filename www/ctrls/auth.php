<?php
class Auth extends Ctrl {
	protected $model;
	public function __construct() {
		parent::__construct();
		$this->initModel();
	}
	protected function initModel() {
		$this->model = new AuthModel();
	}
	public function loginform() {
		$view = new LoginView();
		$view->loginJs = $this->model->getLoginJs();
		$view->display();
	}
	public function login() {
		$res = null;
		$res->done = false;
		$res->error = '';
		if( ( $login = trim( Input::get('login') ) ) && ( $pass = trim( Input::get('pass') ) ) ) {
			if( $this->model->login($login,$pass) ) {
				$res->done = true;
			}else{
				$res->error = "Wrong login/pass";
			}
		}else{
			$res->error = "Login or password is empty";
		}
		Response::json($res);
	}
	public function logout() {
		$this->model->logout();
		$this->loginform();
	}
	public function check() {
		if(!$this->model->check()){
			die();
		}
	}
	public function checkUI() {
		if(!$this->model->check()){
			$this->loginform();
			die();
		}
	}
	public function index() {
		$this->checkUI();
		$ctrl = Config::$default['ctrl'];
		$action = Config::$default['action'];
		$ctrl = new $ctrl;
		$ctrl->$action();
	}
	public function getHash() {
		return $this->model->getCurrentHash();
	}
}
<?php
class Auth extends Ctrl {
	private $model;
	public function __construct() {
		parent::__construct();
		$this->model = new AuthModel();
	}
	public function loginform() {
		$view = new LoginView();
		$view -> display();
	}
	public function login() {
		$res = null;
		$res->done = false;
		$res->error = '';
		if( ( $login = trim( Input::get('login') ) ) && ( $pass = trim( Input::get('pass') ) ) ) {
			if( $this->model->login($login,$pass) ) {
				$res->done = true;
			}else{
				$res->error = "User with typed login/pass doesn't exist";
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
}
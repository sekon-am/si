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
		if( ( $login = Input::get('login') ) && ( $pass = Input::get('pass') ) ) {
			if( $this->model->login($login,$pass) ) {
				$res->done = true;
			}else{
				$res->error = "User with typed login/pass doesn't exist";
			}
		}else{
			$res->error = "User with typed login/pass doesn't exist";
		}
		Response::json($res);
	}
	public function logout() {
		$this->model->logout();
		$this->loginform();
	}
}
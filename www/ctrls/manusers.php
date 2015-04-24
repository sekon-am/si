<?php
class ManUsers extends Ctrl {
	protected $auth;
	protected $model;
	public function __construct() {
		parent::__construct();
		$this->auth = new Admin();
		$this->model = new UsersModel();
	}
	public function index() {
		$this->auth->checkUI();
		$view = new ManUsersView();
		$view->display();
	}
	public function lst() {
		Response::json( $this->model->lst() );
	}
	public function add() {
		$login = Input::get('login');
		$email = Input::get('email');
		$pass = Input::get('pass');
		Response::json(
			$this->model->add($login,$email,$pass) 
		);
	}
	public function del() {
		Response::json( 
			$this->model->del( 
				Input::get('id') 
			)
		);
	}
}
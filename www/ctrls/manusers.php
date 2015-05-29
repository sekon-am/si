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
		$this->auth->check();
		Response::json( $this->model->lst() );
	}
	public function add() {
		$this->auth->check();
		$login = Input::get('login');
		$email = Input::get('email');
		$pass = Input::get('pass');
		Response::json(
			$this->model->add($login,$email,$pass) 
		);
	}
	public function del() {
		$this->auth->check();
		Response::json( 
			$this->model->del( 
				Input::get('id') 
			)
		);
	}
	public function chpass() {
		Response::json(
			$this->model->chpass(
				Input::session('login'),
				Input::get('pass')
			)
		);
	}
}
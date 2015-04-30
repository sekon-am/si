<?php
class Subscribe extends WareLog {
	private $model;
	public function __construct() {
		parent::__construct();
		$this->model = new SubscribeModel();
	}
	public function add() {
		$this->auth->check();
		if($cidr = Input::get('cidr')){
			$ips = Ip::cidr2range($cidr);
			$ip_start = $ips->ip_start;
			$ip_finish = $ips->ip_finish;
		}else{
			$ip_start = Input::get('ip_start');
			$ip_finish = Input::get('ip_finish');
		}
		if( $id = $this->model->add($ip_start,$ip_finish) ) {
			$res = $this->model->get($id);
		}else{
			$res = new Obj(
				array(
					'id' => 0,
					'message' => 'Range already exists',
				)
			);
		}
		Response::json($res);
	}
	public function del() {
		$this->auth->check();
		$id = Input::get('id');
		Response::json( 
			new Obj( 
				array(
					'affected'=>$this->model->del($id)
				)
			)
		);
	}
	public function lst() {
		$this->auth->check();
		Response::json($this->model->lst());
	}
	public function index() {
		$this->auth->checkUI();
		$view = new SubscribeView();
		$view->hash = $this->auth->getHash();
		$view->display();
	}
}
<?php
class Admin extends Auth {
	protected function initModel() {
		$this->model = new AdminAuthModel();
	}
	public function index() {
		$ctrl = new ManUsers();
		$ctrl->index();
	}
}
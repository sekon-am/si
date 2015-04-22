<?php
class LoginView extends DefaultView {
	public function loadMainMenu() {}
	public function loadMainModule() {
		echo $this->loadTpl('loginform');
	}
}
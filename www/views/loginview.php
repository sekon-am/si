<?php
class LoginView extends DefaultView {
	public function loadMainModule() {
		echo $this->loadTpl('loginform');
	}
}
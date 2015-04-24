<?php
class ManUsersView extends DefaultView {
	public function loadMainMenu(){
		echo $this->loadTpl('adminmenu');
	}
	public function loadMainModule(){
		echo $this->loadTpl('manusers');
	}
}
<?php
class RecoveryView extends DefaultView {
	public function loadMainMenu() {}
	public function loadMainModule() {
		echo $this->loadTpl('recoveryform');
	}
}
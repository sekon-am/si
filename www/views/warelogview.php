<?php
class WareLogView extends DefaultView {
	public function loadMainMenu(){
		echo $this->loadTpl('mainmenu');
	}
	public function loadMainModule(){
		echo $this->loadTpl('warelog');
	}
}
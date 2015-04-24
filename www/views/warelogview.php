<?php
class WareLogView extends DefaultView {
	public function loadMainMenu(){
		echo $this->loadTpl('mainmenu');
	}
	public function loadMainModule(){
		echo $this->loadTpl('warelog');
	}
	public function loadWareTable() {
		echo $this->loadTpl('waretable');
	}
	public function loadWareFeeds(){
		echo $this->loadTpl('warefeeds');
	}
}
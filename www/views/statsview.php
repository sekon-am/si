<?php
class StatsView extends DefaultView {
	public function loadMainMenu(){
		echo $this->loadTpl('mainmenu');
	}
	public function loadMainModule(){
		echo $this->loadTpl('stats');
	}
}
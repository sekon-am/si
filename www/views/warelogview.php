<?php
class WareLogView extends DefaultView {
	private $innerPage;
	public function __construct($innerPage = 'warelog') {
		parent::__construct();
		$this->innerPage = $innerPage;
	}
	public function loadMainMenu(){
		echo $this->loadTpl('mainmenu');
	}
	public function loadMainModule(){
		echo $this->loadTpl($this->innerPage);
	}
	public function loadWareTable() {
		echo $this->loadTpl('waretable');
	}
}
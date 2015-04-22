<?php
class WareLogView extends DefaultView {
	public function loadMainModule(){
		echo $this->loadTpl('warelog');
	}
}
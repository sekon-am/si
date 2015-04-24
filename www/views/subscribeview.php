<?php
class SubscribeView extends WareLogView {
	public function loadMainModule(){
		echo $this->loadTpl('subscribe');
	}
}
<?php
abstract class DefaultView extends View {
	abstract public function loadMainMenu();
	abstract public function loadMainModule();
	public function toString() {
		return $this->loadTpl('index');
	}
}
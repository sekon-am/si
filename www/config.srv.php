<?php
class Config {
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASS = 'kiotemotemambasamba';
	const DB_NAME = 'sfp';
	public static $default = array(
		'ctrl' => 'WareLog',
		'action' => 'index',
		'tpl' => 'default',
	);
	const SETS_PER_PAGE = 50;
}

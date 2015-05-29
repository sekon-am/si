<?php
class Config {
	const DB_HOST = '10.200.50.17';
	const DB_USER = 'si';
	const DB_PASS = '3mn098yhczw23';
	const DB_NAME = 'si';
	public static $default = array(
		'ctrl' => 'Stats',
		'action' => 'index',
		'tpl' => 'default',
	);
	const SETS_PER_PAGE = 50;
	const ROWS_FORMAT =10000;
	const USER_HASH_LENGTH = 20;
	const ADMIN_LOGIN = 'admin';
	const ADMIN_PASS = '21232f297a57a5a743894a0e4a801fc3';
}
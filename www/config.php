<?php
class Config {
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASS = '';
	const DB_NAME = 'test';
	public static $default = array(
		'ctrl' => 'WareLog',
		'action' => 'index',
		'tpl' => 'default',
	);
	const SETS_PER_PAGE = 50;
	const USER_HASH_LENGTH = 20;
	const ADMIN_LOGIN = 'admin';
	const ADMIN_PASS = '21232f297a57a5a743894a0e4a801fc3';
}
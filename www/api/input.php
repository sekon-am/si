<?php
class Input {
	private static function value($name, &$array) {
		return htmlspecialchars(addslashes($array[$name]));
	}
	public static function get($name) {
		return self::value($name,$_GET);
	}
	public static function post($name) {
		return self::value($name,$_POST);
	}
}
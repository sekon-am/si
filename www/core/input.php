<?php
class Input {
	private static function value($name, $array) {
		if($name && array_key_exists($name,$array)){
			return htmlspecialchars(addslashes($array[$name]));
		}
		return null;
	}
	public static function get($name) {
		return self::value($name,$_GET);
	}
	public static function post($name) {
		return self::value($name,$_POST);
	}
	public static function request($name) {
		return self::value($name,$_REQUEST);
	}
	public static function session($name) {
		return self::value($name,$_SESSION);
	}
}
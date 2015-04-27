<?php
class Log {
	private static $logFileName = 'log.txt';
	public static function setFileName($logFileName) {
		self::$logFileName = $logFileName;
	}
	public static function write($str) {
		file_put_contents( self::$logFileName, $str."\n", FILE_APPEND );
	}
	public static function output($str) {
		die($str);
	}
}
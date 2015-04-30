<?php
class Response {
	static private $headerSent = FALSE;
	static private function header($header) {
		if(! self::$headerSent) {
			self::$headerSent = TRUE;
			header($header);
		}
	}
	static public function json($data) {
		self::header('Content-type: application/json');
		echo json_encode($data);
	}
	static public function text($txt) {
		self::header('Content-Type: text/plain');
		echo $txt;
	}
	static public function xml($xml) {
		self::header('Content-Type: application/xhtml+xml');
		echo $xml;
	}
	static private function arrayToXml($array, $rootElement = null, $xml = null) {
		$_xml = $xml;

		if ($_xml === null) {
			$_xml = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root></root>');
		}

		foreach ($array as $k => $v) {
			if( is_int($k) ) {
				$k = 'item';
			}
			if (is_object($v)){
				$v = (array) $v;
			}
			if (is_array($v)) { //nested array
				self::arrayToXml($v, $k, $_xml->addChild($k));
			} 
			else {
				$_xml->addChild($k, $v);
			}
		}
		return $_xml->asXML();
	}
}
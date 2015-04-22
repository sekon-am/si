<?php
class Response {
	static public function json($data) {
		header('Content-type: application/json');
		echo json_encode($data);
	}
	static public function text($txt) {
		header('Content-Type: text/plain');
		echo $txt;
	}
	static public function xml($xml) {
		header('Content-Type: application/xhtml+xml');
		echo $xml;
	}
}
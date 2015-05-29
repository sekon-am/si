<?php
class Str {
	static public function rand ($len) {
		$letters = "abcdefghijklmnopqrstuvwxyz";
		$symbs = "0123456789".$letters.strtoupper($letters);
		$str = '';
		for($i=0;$i<$len;$i++){
			$str .= $symbs{mt_rand(0,strlen($symbs)-1)};
		}
		return $str;
	}
}
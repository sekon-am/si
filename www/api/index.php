<?php
set_time_limit(0);
function autoloader($class) {
	include_once(strtolower($class).'.php');
}
spl_autoload_register('autoloader');

$action = Input::get('action');
$sfp = new Sfpctrl();
if(method_exists($sfp,$action)){
	call_user_func(array($sfp,$action));
}else{
	die("Undefined method {$action} in class Sfpctrl");
}
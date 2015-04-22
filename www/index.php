<?php
set_time_limit(0);
function autoloader($class) {
	foreach( array('','core/','libs/','models/','views/','ctrls/',) as $path ) {
		$fname = $path . strtolower( $class ) . '.php';
		if( file_exists( $fname ) ) {
			include_once( $fname );
		}
	}
}
spl_autoload_register('autoloader');

function getControll( $name ) {
	$confField = 'default_'.$name;
	if( ($value = Input::get($name)) || ($value = Config::$default[$name]) ){
		return $value;
	}else{
		die("{$name} is undefined");
	}
}
$ctrlName = getControll('ctrl');
if( strpos($ctrlName,'/') !== FALSE )die("Ctrl includes '/' symbol");
$action = getControll('action');
if(class_exists($ctrlName)){
	$ctrl = new $ctrlName();
	if(method_exists($ctrl,$action)){
		call_user_func(array($ctrl,$action));
	}else{
		die("Can't find {$action} in {$ctrlName}");
	}
}else{
	die("There is no {$ctrlName}");
}

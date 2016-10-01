<?php
session_start();
// error reporting

$GLOBALS['config'] = array(
	'site' => array(
		'name' => 'Kademiks',
		'headline' => 'Ladder To A Green GP',
		'keywords' => 'Kademiks Unilag Lasu Ife Ladder To A Green GP',
		'description' => 'Ladder To A Green GP',
		'contactMail' => 'admin@kademiks.com',
		'url' => 'http://kademiks.com/',
		'author' => 'Lord Pein VII',
		'db_prefix' => 'kadeaqiz_',
		'color' => (isset($_COOKIE['color'])) ? $_COOKIE['color'] : 'primary' ,
		'environment' => 'live'
	),
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'kadeaqiz_user',
		'password' => '*I6.I3LgAu6k',
		'db' => "kadeaqiz_" . (isset($_COOKIE['school'])) ? $_COOKIE['school'] : 'unilag'
	),
	'cookie' => array(
		'name' => 'kademiksuser',
		'expiry' => 67392000
	),
	'session' => array(
		'name' => 'matric',
		'token_name' => 'token'
	)
);

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

spl_autoload_register(function($class) {

	if(file_exists(dirname( __FILE__ ) . '/core/' . $class . '.php')){
	
		require_once dirname( __FILE__ ) . '/core/' . $class . '.php';
	
	}else if(file_exists(dirname( __FILE__ ) . '/classes/' . $class . '.php')){
	
		require_once dirname( __FILE__ ) . '/classes/' . $class . '.php';
	
	}else if(file_exists(dirname( __FILE__ ) . '/controllers/' . $class . '.php')){

		require_once dirname( __FILE__ ) . '/controllers/' . $class . '.php';
	
	}

});



?>
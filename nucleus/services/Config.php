<?php
$GLOBALS['config'] = array(
	'site' => [
		'name' => 'Bookseller',
		'headline' => '...your link to quality books at affordable prices',
		'keywords' => 'Bookseller',
		'description' => 'Your link to quality books at affordable prices',
		'contactMail' => 'info@bookseller.com',
		'url' => 'http://lordpein.lp/bookseller',
		'author' => 'Akingbade Ayobami',
		'db_prefix' => "",
		'color' => 'primary',
		'environment' => 'development', // production
		'lang' => 'en'
	],
	'mysql' => [
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'bookseller'
	],
	'cookie' => [
		'name' => 'bookselleruser',
		'expiry' => 67392000
	],
	'auth' => [
		'table' => 'users',
		'activation' => true,
		'activation_table' => 'activations'
	],
	'views' => [
		'directory' => '/partials/'
	],
	'session' => [
		'name' => 'bookselleruser_session',
		'token_name' => '__token',
		'table' => 'users_session'
	]
);
?>

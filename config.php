<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "ecardapio";

define('PATH', "http://localhost/ecardapio/");
define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/ecardapio");

return [
	'login' => [
		'admin' => [
			'loggedIn' => 'admin_login',
			'redirect' => '/login',
			'idLoggedIn' => 'id_admin',
		],
		'user' => [
			'loggedIn' => 'user_login',
			'redirect' => '/',
			'idLoggedIn' => 'id_user',
		],
	],
	'sql' => [
		'host'=>'localhost',
		'user'=>'root',
		'db'=>'ecardapio',
		'password'=>'bancodedados'
	]
];
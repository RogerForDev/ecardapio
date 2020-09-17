<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', 'bancodedados');
define('DBNAME', 'ecardapio');

// define('PATH', "http://localhost/ecardapio/");
// define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/ecardapio");

define('PATH', "http://bfe42e2169b3.ngrok.io/");
define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/");
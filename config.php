<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "bancodedados";
$config['db']['dbname'] = "ecardapio";

define('PATH', "http://localhost/ecardapio/");
define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/ecardapio");
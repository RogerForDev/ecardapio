<?php

$tipo_conexao = $_SERVER['HTTP_HOST'];
if (($tipo_conexao == 'localhost') || ($tipo_conexao == '127.0.0.1')){
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 'On');

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');
    define('DBNAME', 'ecardapio');

    define('PATH', "http://localhost/ecardapio/");
    define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/ecardapio");
}else{
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 'On');

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    define('DBHOST', 'mysql669.umbler.com');
    define('DBUSER', 'rogerw');
    define('DBPASS', '9}jM5-twjM(');
    define('DBNAME', 'ecardapio');

    define('PATH', "http://proj-ecardapio-com-br.umbler.net/");
    define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/");
}

// define('PATH', "http://bfe42e2169b3.ngrok.io/");
// define('DIR_PATH', $_SERVER['DOCUMENT_ROOT']."/");
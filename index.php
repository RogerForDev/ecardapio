<?php
session_start();

require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("views/");
$container['upload_directory'] = __DIR__ . '/fotos';
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];    
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . 
            $db['dbname'].';charset=utf8',$db['user'], $db['pass']); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);    
    return $pdo;
};

require_once "app/routes.php";
$app->run();
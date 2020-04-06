<?php
session_start();

require 'vendor/autoload.php';
require 'config.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("views/");

require_once "app/routes.php";
$app->run();
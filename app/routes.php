<?php

// ADMINISTRAÇAO
$app->get('/admin/login', 'App\Controllers\Admin\LoginAction:index');
$app->get('/admin/logout', 'App\Controllers\Admin\LoginAction:logout');
$app->post('/admin/login', 'App\Controllers\Admin\LoginAction:logar');

$app->group('/admin', function(){

    $this->get('', 'App\Controllers\Admin\HomeAction:index');
    
    //USER
    $this->get('/users', 'App\Controllers\Admin\UserController:index');
    $this->get('/users/profile', 'App\Controllers\Admin\UserController:profile');
    $this->post('/users/create', 'App\Controllers\Admin\UserController:create');
    $this->post('/users/{id}', 'App\Controllers\Admin\UserController:update');
    $this->get('/users/{id}/delete', 'App\Controllers\Admin\UserController:delete');
    $this->post('/users/{id}/password', 'App\Controllers\Admin\UserController:updatePassword');
    
})->add(App\Middleware\Admin\AuthMiddleware::class);

// SITE
$app->get('/', 'App\Controllers\Site\HomeAction:index');
$app->post('/cadastrar', 'App\Controllers\Site\HomeAction:cadastrar');
// $app->get('/editor', 'App\Controllers\Site\HomeAction:editor');
$app->get('/login', 'App\Controllers\Site\LoginAction:index');
$app->post('/login', 'App\Controllers\Site\LoginAction:login');
$app->get('/logout', 'App\Controllers\Site\LoginAction:logout');
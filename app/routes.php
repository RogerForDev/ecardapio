<?php

// ADMINISTRAÇAO
$app->get('/admin/login', 'App\Controllers\Admin\LoginAction:index');
$app->get('/admin/logout', 'App\Controllers\Admin\LoginAction:logout');
$app->post('/admin/login', 'App\Controllers\Admin\LoginAction:logar');

$app->group('/admin', function(){

    $this->get('', 'App\Controllers\Admin\ProdutoController:index');
    
    //USER
    $this->get('/users', 'App\Controllers\Admin\UserController:index');
    $this->post('/users/create', 'App\Controllers\Admin\UserController:create');
    $this->post('/users/update', 'App\Controllers\Admin\UserController:update');
    $this->get('/users/{id}/delete', 'App\Controllers\Admin\UserController:delete');
    $this->post('/users/{id}/password', 'App\Controllers\Admin\UserController:updatePassword');
    
    //CATEGORIA
    $this->get('/categorias', 'App\Controllers\Admin\CategoriaController:index');
    $this->post('/categorias/create', 'App\Controllers\Admin\CategoriaController:create');
    $this->post('/categorias/{id}', 'App\Controllers\Admin\CategoriaController:update');
    $this->get('/categorias/{id}/delete', 'App\Controllers\Admin\CategoriaController:delete');

    //PRODUTO
    $this->get('/produtos', 'App\Controllers\Admin\ProdutoController:index');
    $this->post('/produtos/create', 'App\Controllers\Admin\ProdutoController:create');
    $this->post('/produtos/{id}', 'App\Controllers\Admin\ProdutoController:update');
    $this->get('/produtos/{id}/delete', 'App\Controllers\Admin\ProdutoController:delete');
    $this->get('/cardapio/{id}', 'App\Controllers\Admin\ProdutoController:define_tema');

    //TEMA
    $this->get('/temas', 'App\Controllers\Admin\TemaController:index');
    $this->post('/temas/create', 'App\Controllers\Admin\TemaController:create');
    $this->post('/temas/{id}', 'App\Controllers\Admin\TemaController:update');
    $this->get('/temas/{id}/delete', 'App\Controllers\Admin\TemaController:delete');
    
})->add(App\Middleware\Admin\AuthMiddleware::class);

// SITE
$app->get('/', 'App\Controllers\Site\HomeAction:index');
$app->post('/cadastrar', 'App\Controllers\Site\HomeController:cadastrar');
$app->post('/logar', 'App\Controllers\Site\HomeController:logar');
$app->get('/cardapio', 'App\Controllers\Site\HomeController:cardapio');
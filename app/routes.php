<?php

$app->group('/admin', function(){

    $this->get('', 'App\Controllers\Admin\ProdutoController:index');
    $this->get('/logout', 'App\Controllers\Site\HomeController:logout');
    
    //USER
    $this->get('/users', 'App\Controllers\Admin\UserController:index');
    $this->post('/users/update', 'App\Controllers\Admin\UserController:update');
    
    //CATEGORIA
    $this->get('/categorias', 'App\Controllers\Admin\CategoriaController:index');
    $this->post('/categorias/create', 'App\Controllers\Admin\CategoriaController:create');
    $this->post('/categorias/{id}', 'App\Controllers\Admin\CategoriaController:update');
    $this->get('/categorias/{id}/delete', 'App\Controllers\Admin\CategoriaController:delete');

    //PRODUTO
    $this->get('/produtos', 'App\Controllers\Admin\ProdutoController:index');
    $this->get('/produtos/busca', 'App\Controllers\Admin\ProdutoController:busca');
    $this->post('/produtos/create', 'App\Controllers\Admin\ProdutoController:create');
    $this->post('/produtos/{id}', 'App\Controllers\Admin\ProdutoController:update');
    $this->get('/produtos/{id}/delete', 'App\Controllers\Admin\ProdutoController:delete');
    $this->get('/comentario/{id}/delete', 'App\Controllers\Admin\ProdutoController:delete_comentario');
    
    //CARDAPIO
    $this->post('/cardapios/create', 'App\Controllers\Admin\CardapioController:create');
    $this->get('/cardapio/tema/{id}', 'App\Controllers\Admin\ProdutoController:define_tema');
    $this->get('/cardapio/layout/{id}', 'App\Controllers\Admin\ProdutoController:define_layout');
    $this->post('/cardapio/background', 'App\Controllers\Admin\ProdutoController:define_background');

    //PLANOS
    $this->get('/planos', 'App\Controllers\Admin\PlanoController:index');
    $this->post('/planos/update', 'App\Controllers\Admin\PlanoController:update');

    //TEMA
    $this->get('/temas', 'App\Controllers\Admin\TemaController:index');
    $this->post('/temas/create', 'App\Controllers\Admin\TemaController:create');
    $this->post('/temas/{id}', 'App\Controllers\Admin\TemaController:update');
    $this->get('/temas/{id}/delete', 'App\Controllers\Admin\TemaController:delete');
    
})->add(App\Middleware\Admin\AuthMiddleware::class);

// SITE
$app->get('/', 'App\Controllers\Site\HomeController:index');
$app->get('/cadastrar', 'App\Controllers\Site\HomeController:cadastrar')->add(App\Middleware\Admin\AuthMiddleware::class);
$app->post('/cadastrar', 'App\Controllers\Site\HomeController:new_user');
$app->post('/logar', 'App\Controllers\Site\HomeController:logar');
$app->post('/verify_login', 'App\Controllers\Site\HomeController:verify_logar');
$app->get('/web/{slug}', 'App\Controllers\Site\HomeController:cardapio');
$app->post('/avaliar', 'App\Controllers\Site\HomeController:avaliar');
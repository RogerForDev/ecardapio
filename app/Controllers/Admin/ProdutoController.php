<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\Cardapio;
use App\models\admin\Categoria;
use App\models\admin\Produto;
use App\src\Validate;

class ProdutoController extends Controller
{
    public function index($request, $response)
    {
        $produto = new Produto;

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];
        
        $lista = $produto->getProdByCardapio($id_cardapio);

        $categoria = new Categoria;

        $vars = [
            "page" => "produtos/cardapio",		
            "data" => $lista,
            "categorias" => $categoria->select()->get()
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }

    public function create()
    {
        $validate = new Validate;

        $data = (array) $validate->validate([
            'nome' => 'required:min@3'
        ]);
        
        if($validate->hasErrors()) {
            return back();
        }

        $item = new Produto;

        $id_produto = $item->create($data);
        
        if($id_produto){
            $id_cardapio = Cardapio::getFromUser()['id_cardapio'];
            $item->saveProdCardapio($id_cardapio, $id_produto);
            flash('message', success('Cadastrado com sucesso!'));
            return back();
        }
        
		flash('message', error('Erro ao cadastrar, tente novamente'));
		return back();      
    }        
    public function update($request, $response, $args){

        $validate = new Validate;

		$data = $validate->validate([
			'nome' => 'required'
		]);

		if ($validate->hasErrors()) {
			return back();
        }
        
        $item = new Produto;

		$updated = $item->find('id_item', $args['id'])->update((array) $data);

		if ($updated) {
			flash('message', success('Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar'));
		back(); 
    }
    public function delete($request, $response, $args)
    {   
        $item = new Produto;
		$deleted = $item->find('id_item', $args['id'])->delete();

		if ($deleted) {
			flash('message', success('Deletado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao deletar'));
		back();
    }
}
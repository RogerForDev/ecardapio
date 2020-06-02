<?php

namespace App\Controllers\Admin;

use App\src\Upload;
use App\src\Validate;
use App\models\admin\User;
use App\models\admin\Produto;
use App\models\admin\Cardapio;
use App\Controllers\Controller;
use App\models\admin\Categoria;
use App\models\admin\Tema;

class ProdutoController extends Controller
{
    public function index($request, $response)
    {
        $produto = new Produto;
        $categoria = new Categoria;       
        $tema = new Tema;       

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];
        
       // $lista = $produto->getProdByCardapio($id_cardapio);
        
        $categorias = $categoria->select()->where("id_cardapio", $id_cardapio)->get();

        foreach($categorias as &$cat){
            $cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
        }

        $vars = [
            "page" => "home",	
            "cardapio" => $categorias, 
            "usuario" => User::getFromSession(),
            "temas" => $tema->select()->get()
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
        
        if(isset($_FILES)){
            $upload = new Upload(); 
            $data['imagem'] = $upload->upload("imagem-produto", "produto");
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

		$data = (array) $validate->validate([
			'nome' => 'required'
		]);

		if ($validate->hasErrors()) {
			return back();
        }

        if($_FILES["imagem-produto"]["error"] != 4){
            $upload = new Upload(); 
            $data['imagem'] = $upload->upload("imagem-produto", "produto");
        }
        
        $item = new Produto;

		$updated = $item->find('id_produto', $args['id'])->update( $data);

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
		$deleted = $item->find('id_produto', $args['id'])->delete();

		if ($deleted) {
			flash('message', success('Deletado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao deletar'));
		back();
    }

    public function define_tema($request, $response, $args){
        $cardapio = new Cardapio;

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];

        $defined = $cardapio->find('id_cardapio', $id_cardapio)->update(['id_tema'=>$args['id']]);

        if($defined){
            flash('message', success('Atualizado com sucesso'));
			return back();
        }
    }
}
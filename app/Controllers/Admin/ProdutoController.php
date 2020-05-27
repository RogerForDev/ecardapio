<?php

namespace App\Controllers\Admin;

use App\src\Upload;
use App\src\Validate;
use App\models\admin\User;
use App\models\admin\Produto;
use App\models\admin\Cardapio;
use App\Controllers\Controller;
use App\models\admin\Categoria;

class ProdutoController extends Controller
{
    public function index($request, $response)
    {
        $produto = new Produto;
        $categoria = new Categoria;       

       // $id_cardapio = Cardapio::getFromUser()['id_cardapio'];
        
       // $lista = $produto->getProdByCardapio($id_cardapio);
        
        $categorias = $categoria->select()->get();

        foreach($categorias as &$cat){
            $cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
        }

        $vars = [
            "page" => "home",	
            "cardapio" => $categorias, 
            "usuario" => User::getFromSession()
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
}
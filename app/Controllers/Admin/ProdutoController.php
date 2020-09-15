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
use App\models\admin\Avaliacao;

class ProdutoController extends Controller
{
    public function index($request, $response)
    {
        $cardapio = new Cardapio;
        $produto = new Produto;
        $categoria = new Categoria;       
        $tema = new Tema;       

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];

        $cardapio = $cardapio->getFromUser();
        
        $categorias = $categoria->select()->where("id_cardapio", $id_cardapio)->get();

        foreach($categorias as &$cat){
            $cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
        }

        $prods = $produto->getProdByCardapio($id_cardapio);
        (!empty($prods))?$flag_produtos = 1 : $flag_produtos = 0;

        $user = User::getFromSession();

        $vars = [
            "page" => "home",	
            "categorias" => $categorias, 
            "cardapio" => $cardapio,
            "usuario" => $user,
            "temas" => $tema->getByUsuario($user['id_usuario']),
            "flag_produtos" => $flag_produtos,
            "tema" => $tema->findBy('id_tema', $cardapio['id_tema'])
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }

    public function busca($request, $response){
        $cardapio = new Cardapio;
        $produto = new Produto;
        $categoria = new Categoria; 
        $tema = new Tema;

        $filtro = $_GET['produto'];
        $cardapio = $cardapio->getFromUser();

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];

        $categorias = $categoria->select()->where("id_cardapio", $id_cardapio)->get();

        foreach($categorias as &$cat){
            $cat['produtos'] = $produtos = $produto->getProdByName($id_cardapio, $filtro, $cat['id_categoria']);
        }
        
        $prods = $produto->getProdByCardapio($id_cardapio);
        (!empty($prods))?$flag_produtos = 1 : $flag_produtos = 0;
        
        foreach($categorias as $key => $cat){
            if(empty($cat['produtos'])){
                unset($categorias[$key]);
            }
        }

        $vars = [
            "page" => "home",	
            "categorias" => $categorias, 
            "cardapio" => $cardapio,
            "usuario" => User::getFromSession(),
            "temas" => $tema->select()->get(),
            "flag_produtos" => $flag_produtos
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

        if(isset($_POST['ativo'])){
            $data['ativo'] = 1;
        }else{
            $data['ativo'] = 0;
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
            echo 1;
        }
    }
    public function define_layout($request, $response, $args){
        $cardapio = new Cardapio;

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];

        $defined = $cardapio->find('id_cardapio', $id_cardapio)->update(['id_layout'=>$args['id']]);

        if($defined){
            echo 1;
        }
    }
    public function define_background($request, $response, $args){
        $cardapio = new Cardapio;

        $id_cardapio = Cardapio::getFromUser()['id_cardapio'];

        if(isset($_FILES)){
            $upload = new Upload(); 
            $imagem = $upload->upload("imagem-fundo", "tema");
        }

        $defined = $cardapio->find('id_cardapio', $id_cardapio)->update(['imagem'=>$imagem]);

        if($defined){
            flash('message', success('Atualizado com sucesso'));
			return back();
        }
    }

}
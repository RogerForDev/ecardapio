<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\Categoria;
use App\models\admin\Cardapio;
use App\src\Validate;
use App\Util\Upload;

class CategoriaController extends Controller
{
    public function index($request, $response)
    {
        $categoria = new Categoria;
        $categorias = $categoria->select()->orderBy('id_categoria', 'DESC')->get();

        $vars = [
            "page"=> "categorias/categorias",		
            "categorias" => $categorias
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }
    public function create()
    {
        $data = array();

        if(isset($_FILES)){
            $upload = new Upload(); 
            $result = $upload->upload("imagem-categoria");
        }

        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $data['nome'] = addslashes(htmlspecialchars($_POST['nome']));
        }else{
            echo json_encode(array("type" => "erro", "message" => "Nome da categoria não informado!"));
            exit;  
        }

        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $data['ativo'] = addslashes(htmlspecialchars($_POST['ativo']));
        }else{
            echo json_encode(array("type" => "erro", "message" => "Não foi informado se a categoria estará ativa ou não!"));
            exit;  
        }
        
        $categoria = new Categoria;
        $cardapio = new Cardapio;

        $cardapio = $cardapio->getFromUser();

        $data['imagem'] = $result;
        $data['id_cardapio'] = $cardapio['id_cardapio'];
        // print_r($data);exit;

        $categoria = $categoria->create($data);

        if($categoria){
            echo json_encode(array("type" => "sucesso", "message" => "Categoria cadastrado com sucesso!", "nome" => $data['nome']));
            exit;
        }
        
		echo json_encode(array("type" => "erro", "message" => "Ocorreu um erro interno!"));
        exit;    
    }        
    public function update($request, $response, $args){

        $validate = new Validate;

		$data = $validate->validate([
			'nome' => 'required'
		]);

		if ($validate->hasErrors()) {
			return back();
        }
        
        $categoria = new Categoria;

		$updated = $categoria->find('id_categoria', $args['id'])->update((array) $data);

		if ($updated) {
			flash('message', success('Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar'));
		back(); 
    }
    public function delete($request, $response, $args)
    {   
        $categoria = new Categoria;
		$deleted = $categoria->find('id_categoria', $args['id'])->delete();

		if ($deleted) {
			flash('message', success('Deletado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao deletar'));
		back();
    }
}
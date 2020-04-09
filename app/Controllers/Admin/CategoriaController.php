<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\Categoria;
use App\src\Validate;

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
        $validate = new Validate;

        $data = (array) $validate->validate([
            'nome' => 'required:min@3'
        ]);
        
        if($validate->hasErrors()) {
            return back();
        }
        $categoria = new Categoria;

        $categoria = $categoria->create($data);

        if($categoria){
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
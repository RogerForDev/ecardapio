<?php

namespace App\Controllers\Admin;

use App\src\Upload;
use App\src\Validate;
use App\models\admin\User;
use App\models\admin\Tema;
use App\models\admin\Cardapio;
use App\Controllers\Controller;
use App\models\admin\Categoria;

class TemaController extends Controller
{
    public function index($request, $response)
    {
        $tema = new Tema;

        $vars = [
            "page" => "home",	
            "temas" => $tema->select()->all()
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
            $data['imagem'] = $upload->upload("imagem-tema", "tema");
        }

        $item = new Tema;

        $id_tema = $item->create($data);
        
        if($id_tema){
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

        if($_FILES["imagem-tema"]["error"] != 4){
            $upload = new Upload(); 
            $data['imagem'] = $upload->upload("imagem-tema", "tema");
        }
        
        $item = new Tema;

		$updated = $item->find('id_tema', $args['id'])->update( $data);

		if ($updated) {
			flash('message', success('Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar'));
		back(); 
    }
    public function delete($request, $response, $args)
    {   
        $item = new Tema;
		$deleted = $item->find('id_tema', $args['id'])->delete();

		if ($deleted) {
			flash('message', success('Deletado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao deletar'));
		back();
    }
}
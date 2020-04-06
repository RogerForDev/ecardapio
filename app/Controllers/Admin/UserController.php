<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\User;
use App\src\Validate;

class UserController extends Controller
{
    public function index($request, $response)
    {
        $user = new User;
        $users = $user->select()->orderBy('id_usuario', 'DESC')->get();

        $vars = [
            "page"=> "users/users",		
            "users" => $users
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }
    public function create()
    {
        $validate = new Validate;

        $data = (array) $validate->validate([
            'nome' => 'required:min@3',
            'senha'=> 'required',
            'email' => 'required:email'
        ]);
        
        if($validate->hasErrors()) {
            return back();
        }
        $user = new User;
        
        $data['senha'] = $user->getPasswordHash($data['senha']);

        $user = $user->create($data);

        if($user){
            flash('message', success('Cadastrado com sucesso!'));
            return back();
        }
        
		flash('message', error('Erro ao cadastrar, tente novamente'));
		return back();      
    }        
    public function update($request, $response, $args){

        $validate = new Validate;

		$data = $validate->validate([
			'nome' => 'required',
			'email' => 'required:email'
		]);

		if ($validate->hasErrors()) {
			return back();
        }
        
        $user = new User;

		$updated = $user->find('id_usuario', $args['id'])->update((array) $data);

		if ($updated) {
			flash('message', success('Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar'));
		back(); 
    }
    public function delete($request, $response, $args)
    {   
        $user = new User;
		$deleted = $user->find('id_usuario', $args['id'])->delete();

		if ($deleted) {
			flash('message', success('Deletado com sucesso'));

			return back();
		}

		flash('message', error('Erro ao deletar'));
		back();
    }
    public function updatePassword($request, $response)
    {      
        $iduser = $request->getAttribute('id');

        if(!is_numeric($iduser)){
            return $response->withRedirect(PATH.'/admin/users');
        }
        if (!isset($_POST['senha']) || $_POST['senha'] === '') {
            flash('message', error('Preencha uma nova senha'));
            back(); 
        }
    
        if (!isset($_POST['senha-confirm']) || $_POST['senha-confirm'] === '') {
            flash('message', error('Preencha a confirmação da nova senha.'));
		    back(); 
        }
    
        if ($_POST['senha'] !== $_POST['senha-confirm']) {
            flash('message', error('Confirme corretamente as senhas.'));
		    back(); 
        }
    
        $user = new User();

        $senha = $user->getPasswordHash($_POST['senha']);
    
        $updated = $user->find('id_usuario', $iduser)->update(['senha'=>$senha]);

        if ($updated) {
			flash('message', success('Senha alterada com sucesso'));
			return back();
		}
    }

    public function profile($request, $response)
    {
        $vars = [ 
            "page"=>"users/profile"
        ];
        return $this->view->render($response, "/admin/index.phtml", $vars);
    }
}
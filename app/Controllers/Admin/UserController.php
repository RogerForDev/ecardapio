<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\User;
use App\models\admin\Cardapio;
use App\src\Validate;
use App\src\Upload;

class UserController extends Controller
{
    public function update($request, $response, $args){

        $validate = new Validate;

		$data = $validate->validate([
			'nome' => 'required',
            'email' => 'required:email',
            'estabelecimento' => 'required',
            'horario' => 'required',
            'cidade' => 'required',
            'rua' => 'required',
            'bairro' => 'required',
            'numero' => 'required'
        ]);

		if ($validate->hasErrors()) {
			return back();
        }
        
        $user = new User;
        $cardapio = new Cardapio;

        if($_FILES["logo"]["error"] != 4){
            $upload = new Upload();
            $imagem = $upload->upload("logo", "logo");
            $cardapio->find('id_usuario', $data->id_usuario)->update(['logo'=>$imagem]);
        }

        $estab = $user->select()->findBy('estabelecimento', $data->estabelecimento);
        
        if(!empty($estab) && ($estab['email'] != $data->email)){
            flash('message', error('Um estabelecimento com esse nome já está cadastrado no sistema!'));
            back(); 
        }

        $updated = $user->find('id_usuario', $data->id_usuario)->update((array) $data);

		if ($updated) {
            $_SESSION[User::SESSION] = get_object_vars($data);
			flash('message', success('Usuário Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar o usuário'));
		back(); 
    }
}
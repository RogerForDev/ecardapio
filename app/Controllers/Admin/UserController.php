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
            'email' => 'email',
        ]);

		if ($validate->hasErrors()) {
			return back();
        }

        $data->flag_wifi = ($data->flag_wifi == 'on')?1:0;
        $data->flag_cartao = ($data->flag_cartao == 'on')?1:0;
        $data->flag_entrega = ($data->flag_entrega == 'on')?1:0;
        
        $user = new User;
        $cardapio = new Cardapio;
        $id_cardapio = $cardapio->select('id_cardapio')->findBy('id_usuario', $data->id_usuario)['id_cardapio'];

        if($_FILES["logo"]["error"] != 4){
            $upload = new Upload();
            $imagem = $upload->upload("logo", "logo");
            $cardapio->save_logo($id_cardapio, $imagem);
            flash('message', success('Usuário Atualizado com sucesso'));
			return back();
        }

        $estab = $user->select()->findBy('estabelecimento', $data->estabelecimento);
        
        if(!empty($estab) && ($estab['email'] != $data->email)){
            flash('message', error('Um estabelecimento com esse nome já está cadastrado no sistema!'));
            back(); 
        }

        $updated = $user->find('id_usuario', $data->id_usuario)->update((array) $data);

		if ($updated) {
            $slug = slugify($data->estabelecimento);
            $cardapio->update_slug($id_cardapio, $slug);
            
            $_SESSION[User::SESSION] = get_object_vars($data);
			flash('message', success('Usuário Atualizado com sucesso'));
			return back();
		}

		flash('message', error('Erro ao atualizar o usuário'));
		back(); 
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\Cardapio;
use App\models\admin\User;
use App\src\Validate;

class CardapioController extends Controller
{
    public function create($request, $response)
    {
        $data['id_layout'] = filter_input(INPUT_POST,'layout', FILTER_SANITIZE_NUMBER_INT);
        $data['id_tema'] = filter_input(INPUT_POST,'tema', FILTER_SANITIZE_NUMBER_INT);

        $flag_wifi = ($_POST['flag_wifi'] == 'on')?1:0;
        $flag_cartao = ($_POST['flag_cartao'] == 'on')?1:0;
        $flag_entrega = ($_POST['flag_entrega'] == 'on')?1:0;
        
        $user = $_SESSION[User::SESSION];
        $data['id_usuario'] = $user['id_usuario'];

        $data['slug'] = slugify($user['estabelecimento']);
        
        $cardapio = new Cardapio;
        $cardapio = $cardapio->create($data);
        
        $usuario = new User;
        $usuario->find('id_usuario', $user['id_usuario'])->update([
            'flag_wifi'=> $flag_wifi, 
            'flag_cartao' => $flag_cartao, 
            'flag_entrega'=>$flag_entrega
        ]);

        if($cardapio){
            redirect(PATH.'admin');
            // echo json_encode(array("type" => "sucesso", "message" => "Cardapio cadastrado com sucesso!", "id" => $cardapio, "path" => PATH."admin"));
            exit;
        }
        
		//echo json_encode(array("type" => "erro", "message" => "Ocorreu um erro interno!"));
       // exit;         
    }        
}
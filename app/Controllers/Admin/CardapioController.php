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
    
        $user = $_SESSION[User::SESSION];
        $data['id_usuario'] = $user['id_usuario'];

        $data['slug'] = slugify($user['estabelecimento']);
        
        $cardapio = new Cardapio;
        $cardapio = $cardapio->create($data);

        if($cardapio){
            redirect(PATH.'admin');
            // echo json_encode(array("type" => "sucesso", "message" => "Cardapio cadastrado com sucesso!", "id" => $cardapio, "path" => PATH."admin"));
            exit;
        }
        
		//echo json_encode(array("type" => "erro", "message" => "Ocorreu um erro interno!"));
       // exit;         
    }        
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\Cardapio;
use App\models\admin\User;
use App\src\Validate;

class CardapioController extends Controller
{
    // public function index($request, $response)
    // {
    //     $user = new User;
    //     $users = $user->select()->orderBy('id_usuario', 'DESC')->get();

    //     $vars = [
    //         "page"=> "users/users",		
    //         "users" => $users
    //     ];
    
    //     return $this->view->render($response, '/admin/index.phtml', $vars);
    // }
    public function create()
    {
        $data = array();
        
        if(isset($_POST['id_layout']) && !empty($_POST['id_layout'])){
            $data['id_layout'] = addslashes(htmlspecialchars($_POST['id_layout']));
        }else{
            echo json_encode(array("type" => "erro", "message" => "Layout não informado!!"));
            exit;  
        }
        
        $user = $_SESSION[User::SESSION];
        $data['id_usuario'] = $user['id_usuario']; 
        
        $cardapio = new Cardapio;
        $cardapio = $cardapio->create($data);

        if($cardapio){
            echo json_encode(array("type" => "sucesso", "message" => "Cadapio cadastrado com sucesso!", "id" => $cardapio, "path" => PATH."admin"));
            exit;
        }
        
		echo json_encode(array("type" => "erro", "message" => "Ocorreu um erro interno!"));
        exit;         
    }        
}
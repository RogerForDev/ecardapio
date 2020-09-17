<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\User;

class PlanoController extends Controller{

    public function index($request, $response)
    {

        $usuario = $_SESSION[User::SESSION];
        $id = $usuario['id_usuario']; 

        $user = new User;

        $data = $user->select()->findBy('id_usuario', $id);

        $vars = [
            "page"=> "planos",
            "usuario"=> $data,
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }

    public function update($request, $response, $args){

        if(isset($_POST['check']) && !empty($_POST['check'])){
            $check = $_POST['check'];
        }else{
            echo json_encode(array("type" => "erro", "message" => "Plano não informado!"));
            exit;  
        }

        $data['flag_assinante'] = $check;

        $user = $_SESSION[User::SESSION];
        $id_user = $user['id_usuario'];
        
        $usuario = new User();

		$updated = $usuario->find('id_usuario', $id_user)->update((array) $data);

		if ($updated) {
            echo json_encode(array("type" => "sucesso", "message" => "Um boleto foi enviado ao seu email para confirmação de assinatura!"));
            exit;
		}

        echo json_encode(array("type" => "erro", "message" => "Ocorreu um erro interno :("));
        exit;  
    }
}
?>
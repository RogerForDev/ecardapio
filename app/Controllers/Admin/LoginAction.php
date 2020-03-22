<?php

namespace App\Controllers\Admin;

use App\Helper as Action;
use App\Model\User;

final class LoginAction extends Action{
        
    public function index($request, $response)
    {
       if (isset($_SESSION[User::SESSION])) {
            return $response->withRedirect(PATH.'admin');
       }
       $vars = [
         //   "descompany"=>$this->getTemplate()['nome'],
            "page"=>"login",
            "error"=>User::getError()
       ];
      
       return $this->view->render($response, 'admin/login.phtml', $vars);
    }
    
    public function logar($request, $response)
    {
        $data = $request->getParsedBody();

        $login = strip_tags(filter_var($data['login'], FILTER_SANITIZE_STRING));
        $password = strip_tags(filter_var($data['password'], FILTER_SANITIZE_STRING));

        // print_r(User::getPasswordHash("teste123"));
        // exit;

        try {
            $this->login($login, $password);
        }catch(\Exception $e){
            User::setError($e->getMessage());		
        }
        return $response->withRedirect(PATH.'admin');           
    }
    public function logout($request, $response)
    {
        unset($_SESSION[User::SESSION]);
        session_destroy();
        return $response->withRedirect(PATH . '/admin/login');
    }

    public function forgot($request, $response)
    {
        $vars = [
            "page"=>"forgot",
            "title"=>$this->getTemplate()['nome']
        ];
    
        return $this->view->render($response, '/admin/forgot.phtml', $vars);
    }

    public function login($login, $password)
    {
        $results = $this->select("SELECT * FROM tb_users a INNER JOIN tb_persons b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN", [":LOGIN"=>$login]);

        if(count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida.1");
        }
        $data = $results[0];

        if(password_verify($password, $data["despassword"]) === true)
        {

            $data['desperson'] = utf8_encode($data['desperson']);

            $user = new User();

            $user->setData($data);

            
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;

        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.2");
        }
    }
}
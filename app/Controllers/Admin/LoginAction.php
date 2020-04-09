<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\models\admin\User;

final class LoginAction extends Controller{
        
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
        $user = new User;

        $data = $user->select()->findBy('login', $login);

        if(count($data) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida.1");
        }

        if(password_verify($password, $data["senha"]) === true)
        {
            $_SESSION[User::SESSION] = $data;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida.2");
        }
    }
}
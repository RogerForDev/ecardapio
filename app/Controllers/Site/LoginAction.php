<?php

namespace App\Action;

use Hcode\Model\User;

final class LoginAction extends Action
{
    public function index($request, $response){
        $template = $this->getTemplate();

        $vars =  [
            'page'=>'login',
            "title"=>"Minha Conta - ".$template['nome'],
            'error'=>User::getError(),
            'errorRegister'=>User::getErrorRegister(),
            'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'','email'=>'','phone'=>'']
        ];

        $vars = array_merge($vars, $template);
        return $this->view->render($response, 'template.phtml', $vars);
    }
    public function login($request, $response){
        $data = $request->getParsedBody();
	
        $login = strip_tags(filter_var($data['login'], FILTER_SANITIZE_STRING));
        $password = strip_tags(filter_var($data['password'], FILTER_SANITIZE_STRING));
    
        try {
            User::login($login, $password);
        }catch(\Exception $e){
            User::setError($e->getMessage());
        }
        return $response->withRedirect(PATH.'/checkout');
    }
    public function logout($request, $response){
        unset($_SESSION[User::SESSION]);
        session_destroy();
        return $response->withRedirect(PATH . '/login');
    }
    public function profile($request, $response)
    {
        $template = $this->getTemplate();
        //User::verifyLogin(false);
        $user = User::getFromSession();

        $vars = [
            "title"=>"Perfil - ".$template['nome'],
            'page'=>'profile',
            'user'=>$user->getValues(),
            'profileMsg'=>User::getSuccess(),
            'profileError'=>User::getError()
        ];
        $vars = array_merge($vars, $template);	 
        return $this->view->render($response, 'template.phtml', $vars);
    }
    public function changePassword($request, $response)
    {
        $template = $this->getTemplate();

        $vars = [
            "title"=>"Alterar senha - ".$template['nome'],
            'page'=>'profile-change-password',
            'changePassError'=>User::getError(),
            'changePassSuccess'=>User::getSuccess()			
        ];
        $vars = array_merge($vars, $template);	 
        return $this->view->render($response, 'template.phtml', $vars);
    }
    public function orders($request, $response)
    {
        $template = $this->getTemplate();
           
        $user = User::getFromSession();
    
        $vars = [
            "title"=>"Pedidos - ".$template['nome'],
            "page"=>"profile-orders",
            "orders"=>$user->getOrders()
        ];
        $vars = array_merge($vars, $template);	 
        return $this->view->render($response, 'template.phtml', $vars);
    }
}
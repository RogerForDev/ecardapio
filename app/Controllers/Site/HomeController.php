<?php

namespace app\controllers\site;

use App\controllers\Controller;
use App\models\site\Post;
use App\models\admin\User;
use App\src\Validate;

class HomeController extends Controller {

	public function index($request, $response) {

		$post = new Post;
		$posts = $post->posts();

		

		$vars = [
			'page' => 'home',
			'title' => 'Blog ASW',
			'posts' => $posts,
			'links' => $post->links()
		];

		return $this->view->render($response,'site/index.phtml', $vars);
	}

	public function logar($request, $response){
		$data = $request->getParsedBody();

        $login = strip_tags(filter_var($data['login'], FILTER_SANITIZE_STRING));
        $password = strip_tags(filter_var($data['senha'], FILTER_SANITIZE_STRING));

        try {
			$result = $this->login($login, $password);
        }catch(\Exception $e){
            $vars = [
				"page"=> "home",		
				"erro-cadastro" => $e->getMessage()
			];
            return $this->view->render($response, '/admin/index.phtml', $vars);		
		}
		
		if($result != 1){
			$vars = [
				"page"=> "home",		
				"erro-cadastro" => "Usuário ou senha inválidos"
			];
            return $this->view->render($response, '/site/index.phtml', $vars);		
		}else{
			return $response->withRedirect(PATH.'admin');
		}
	}

	public function login($login, $password)
    {
		$user = new User;
		
		$data = array();

		$data = $user->select()->findBy('login', $login);

        if(empty($data))
        {
            return 0;
        }

        if(password_verify($password, $data["senha"]) === true)
        {
			$_SESSION[User::SESSION] = $data;
			return 1;
        } else {
            return 0;
        }
    }

	public function cadastrar($request, $response){
		$validate = new Validate;

        $data = (array) $validate->validate([
            'nome' => 'required:min@3',
            'senha'=> 'required',
            'login' => 'required'
        ]);
        
        if($validate->hasErrors()) {
            return back();
        }
        $user = new User;
        
        $data['senha'] = $user->getPasswordHash($data['senha']);

        try{

			$user->create($data);
			
			$vars = [			
				'page'       => 'cadastro-cardapio'
			];
			return $this->view->render($response, 'site/index.phtml', $vars);

        }catch(\Exception $e){
			$vars = [
				"page"=> "home",		
				"erro-cadastro" => $e->getMessage()
			];
            return $this->view->render($response, '/admin/index.phtml', $vars);	
        }  
	}

}
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
            User::setError($e->getMessage());		
        }  
	}

}
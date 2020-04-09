<?php

namespace app\controllers\site;

use App\controllers\Controller;
use App\models\site\Post;
use App\models\admin\User;
use App\src\Validate;

class HomeController extends Controller
{

	public function index($request, $response)
	{

		$post = new Post;
		$posts = $post->posts();



		$vars = [
			'page' => 'home',
			'title' => 'Blog ASW',
			'posts' => $posts,
			'links' => $post->links()
		];

		return $this->view->render($response, 'site/index.phtml', $vars);
	}

	public function cadastrar($request, $response)
	{
		$validate = new Validate;

		$data = (array) $validate->validate([
			'nome' => 'required:min@3',
			'senha' => 'required',
			'login' => 'required:unique@user'
		]);

		if ($validate->hasErrors()) {
			flash('message', error('Erro ao cadastrar, tente novamente'));
			redirect(PATH);
		}
		$user = new User;

		$data['senha'] = $user->getPasswordHash($data['senha']);
		$created = $user->create($data);

		if($created){
			return $this->view->render($response, 'site/index.phtml', ['page' => 'cadastro-cardapio']);
		}else{
			flash('message', error('Erro ao cadastrar, tente novamente'));
			redirect(PATH);
		}
	}
}

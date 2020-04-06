<?php

namespace app\controllers\site;

use app\controllers\Controller;
use app\models\site\Post;

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

}
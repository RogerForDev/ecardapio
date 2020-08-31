<?php

namespace app\controllers\site;

use App\src\Validate;
use App\models\site\Post;
use App\models\admin\Tema;
use App\models\admin\User;
use App\models\admin\Produto;
use App\models\admin\Cardapio;
use App\controllers\Controller;
use App\models\admin\Avaliacao;
use App\models\admin\Categoria;

class HomeController extends Controller
{

	public function index($request, $response)
	{
		$vars = [
			'page' => 'home',
		];

		return $this->view->render($response, 'site/index.phtml', $vars);
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
			$_SESSION['User'] = $data;
			return 1;
        } else {
            return 0;
        }
	}
	public function cadastrar($request, $response){
		return $this->view->render($response, 'site/index.phtml', ['page' => 'cadastro-cardapio']);
	}

	public function new_user($request, $response)
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
			$usuario = $user->getFromId($created);
			$_SESSION[User::SESSION] = $usuario;
			return $response->withRedirect(PATH.'cadastrar');
		}else{
			flash('message', error('Erro ao cadastrar, tente novamente'));
			redirect(PATH);
		}
	}
	public function cardapio($request, $response, $args)
	{
		$produto = new Produto;
		$categoria = new Categoria;
		$tema = new Tema;
		$cardapio = new Cardapio;
		$avaliacao = new Avaliacao;
		$usuario = new User;

		$cardapio = $cardapio->select()->findBy('slug', $args['slug']);
		
	//	dd($cardapio);

		if($cardapio){
			$categorias = $categoria->select()->where('id_cardapio', $cardapio['id_cardapio'])->orderBy('ordem', 'asc')->get();
		}

        foreach($categorias as &$cat){
			$cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
			foreach ($cat['produtos'] as &$val){
				$soma_avaliacao = 0;
				$numero_avaliacao = 0;
				$val['avaliacoes'] = $avaliacao->select()->where('id_produto', $val['id_produto'])->get();
				foreach($val['avaliacoes'] as &$ava){
					$numero_avaliacao++;
					$soma_avaliacao += $ava['nota'];
				}

				if($soma_avaliacao != 0){
					$media_avaliacao = ceil($soma_avaliacao / $numero_avaliacao);
				}else{
					$media_avaliacao = -1;
				}
				
				$val['media'] = $media_avaliacao;
			}

			if($args['flag'] == 2){
				usort(

					$cat['produtos'],
				
					 function( $a, $b ) {
				
						 if( $a['media'] == $b['media'] ) return 0;
				
						 return ( ( $a['media'] > $b['media'] ) ? -1 : 1 );
					 }
				);
			}
		}

		//dd($categorias);
		
		$vars = [
			'page' => 'layout_'.$cardapio['id_layout'],
			'cardapio' => $categorias,
			'fundo' => $cardapio['imagem'],
			'usuario' => $usuario->select()->findBy('id_usuario', $cardapio['id_usuario']),
			'tema' => $tema->select()->findBy('id_tema', $cardapio['id_tema'])
		];
		return $this->view->render($response, 'cardapio/index.phtml', $vars);
	}
}

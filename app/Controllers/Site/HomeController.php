<?php

namespace app\controllers\site;

use App\src\Validate;
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

        $email = strip_tags(filter_var($data['email'], FILTER_VALIDATE_EMAIL));
        $password = strip_tags(filter_var($data['senha'], FILTER_SANITIZE_STRING));

		$result = $this->login($email, $password);
    
		if($result){
			return $response->withRedirect(PATH.'admin');
		}else{
			return $response->withRedirect(PATH);
		}
	}
	public function verify_logar($request, $response){
		$data = $request->getParsedBody();

        $email = strip_tags(filter_var($data['email'], FILTER_VALIDATE_EMAIL));
		$password = strip_tags(filter_var($data['senha'], FILTER_SANITIZE_STRING));
		
		$is_logged_in = $this->login($email, $password);

		if($is_logged_in){
			return $response->withJson(["status"=>"success"]);
		} else{
			return $response->withJson(["status"=>"failed"]);
		}
	}

	public function login($email, $password)
    {
		$user = new User;
		$data = $user->select()->findBy('email', $email);

        if(!empty($data)){
			if(password_verify($password, $data["senha"]) === true){
				$_SESSION['User'] = $data;
				return true;
				exit;
			}
		}
		return false;		
	}
	public function logout($request, $response)
    {
        unset($_SESSION[User::SESSION]);
        session_destroy();
        return $response->withRedirect(PATH);
    }
	public function cadastrar($request, $response){
		return $this->view->render($response, 'site/index.phtml', ['page' => 'cadastro-cardapio']);
	}

	public function new_user($request, $response)
	{
		$validate = new Validate;

		$data = (array) $validate->validate([
			'senha' => 'required',
			'email' => 'required:unique@user',
			'estabelecimento' => 'required:unique@user'
		]);

		if ($validate->hasErrors()) {
			$vars = [
				'page' => 'home',
				"erro_cadastro" => $validate->errors()				
			];	
			return $this->view->render($response, 'site/index.phtml', $vars);
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
	public function cardapio($request, $response, $args){
		$produto = new Produto;
		$categoria = new Categoria;
		$tema = new Tema;
		$cardapio = new Cardapio;
		$avaliacao = new Avaliacao;
		$usuario = new User;

		$filtro = $_GET['busca'];

		$cardapio = $cardapio->select()->findBy('slug', $args['slug']);

		if($cardapio){
			$categorias = $categoria->select()->where('id_cardapio', $cardapio['id_cardapio'])->orderBy('ordem', 'asc')->get();
		}

        foreach($categorias as &$cat){
			if($filtro){
				$cat['produtos'] = $produto->getProdByName($cardapio['id_cardapio'], $filtro, $cat['id_categoria']);
			}else{
				$cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
			}
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

			if(@$_GET['sort'] == 'top'){
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
		//return $response->withJson($categorias);
	}
	public function cardapio_json($request, $response, $args){
		$produto = new Produto;
		$categoria = new Categoria;
		$tema = new Tema;
		$cardapio = new Cardapio;
		$avaliacao = new Avaliacao;
	

		$filtro = $_GET['produto'];

		$cardapio = $cardapio->select()->findBy('slug', $args['slug']);

		if($cardapio){
			$categorias = $categoria->select()->where('id_cardapio', $cardapio['id_cardapio'])->orderBy('ordem', 'asc')->get();
		}

        foreach($categorias as &$cat){
			if($filtro){
				$cat['produtos'] = $produto->getProdByName($cardapio['id_cardapio'], $filtro, $cat['id_categoria']);
			}else{
				$cat['produtos'] = $produto->select()->where("id_categoria", $cat['id_categoria'])->get();
			}
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
		return $response->withJson($categorias);
	}

	public function busca_produto($request, $response){
		
		$produto = new Produto;
		$categoria = new Categoria;
		$tema = new Tema;
		$cardapio = new Cardapio;
		$avaliacao = new Avaliacao;
		$usuario = new User;

		$filtro = $_GET['produto'];
		$slug = $_GET['slug'];

		$cardapio = $cardapio->select()->findBy('slug', $slug);
		
		$id_cardapio = Cardapio::getFromUser()['id_cardapio'];

		if($cardapio){
			$categorias = $categoria->select()->where('id_cardapio', $cardapio['id_cardapio'])->orderBy('ordem', 'asc')->get();
		}

        foreach($categorias as &$cat){
			$cat['produtos'] = $produto->getProdByName($id_cardapio, $filtro, $cat['id_categoria']);
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

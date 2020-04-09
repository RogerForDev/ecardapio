<?php

namespace App\Controllers\Site;

use App\Controllers\Controller;

final class HomeAction extends Controller{
    
    public function index($request, $response)
    {      
       // $template = $this->getTemplate();
       
        $vars = [			
      //      'title'      => 'Home - '.$template['nome'],
            'page'       => 'home'
        ];

     //   $vars = array_merge($vars, $template);
        return $this->view->render($response, 'site/index.phtml', $vars);
    }    
    public function cadastrar($request, $response)
    {      
        $data = $request->getParsedBody();
        
        $nome = strip_tags(filter_var($data['nome'], FILTER_SANITIZE_STRING));
        $login = strip_tags(filter_var($data['login'], FILTER_SANITIZE_STRING));
        $senha = strip_tags(filter_var($data['senha'], FILTER_SANITIZE_STRING));

        $vars = [			
            'page'       => 'cadastrar'
        ];
        return $this->view->render($response, 'site/index.phtml', $vars);
    }     
}


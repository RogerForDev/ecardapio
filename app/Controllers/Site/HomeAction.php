<?php

namespace App\Controllers\Site;

use App\Controllers\Controller;
use App\models\admin\User;

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
}


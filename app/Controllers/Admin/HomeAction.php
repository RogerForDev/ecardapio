<?php

namespace App\Controllers\Admin;

use App\Helper as Action;
use App\Model\User;
use App\Model\Site;
use App\Model\Order;

final class HomeAction extends Action{

    public function index($request, $response)
    {        

        $vars = [
            "page"=>"home",
          //  "title"=>$this->getTemplate()['nome']
        ];
        
        return $this->view->render($response, 'admin/index.phtml', $vars);
    }
}
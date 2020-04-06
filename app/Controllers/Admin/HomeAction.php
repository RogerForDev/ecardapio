<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

final class HomeAction extends Controller{

    public function index($request, $response)
    {                
        return $this->view->render($response, 'admin/index.phtml', ["page"=>"home"]);
    }
}
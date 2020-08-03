<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class PlanoController extends Controller{

    public function index($request, $response)
    {

        $vars = [
            "page"=> "planos",
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }
}
?>
<?php

namespace App\Middleware\Admin;

use App\models\admin\User;

class AuthMiddleware{
    
    public function __invoke($request, $response, $next)   
    {        
        if(!isset($_SESSION[User::SESSION])){
            return $response->withRedirect(PATH);
        }       
        $response = $next($request, $response);       
        
        return $response;
    }
}
<?php

namespace App\Middleware\Admin;
use App\Model\User;

class AuthMiddleware{
    
    public function __invoke($request, $response, $next)   
    {        
        if(!isset($_SESSION[User::SESSION])){
            return $response->withRedirect(PATH.'admin/login');
        }       
        $response = $next($request, $response);       
        
        return $response;
    }
}
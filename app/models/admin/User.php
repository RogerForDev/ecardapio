<?php

namespace App\models\admin;

use App\models\Model;

class User extends Model {

    protected $table = 'tb_usuario';
    protected $id = 'id_usuario';
    
	const SESSION = "User";

    public static function getFromId($id){
        $user = new User;
        return $user->select()->findBy('id_usuario',$id);
    }

    public static function getFromSession()
    {
        if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['id_usuario'] > 0){
          $user =  $_SESSION[User::SESSION];
        }
        return $user;
    }

    public function getPasswordHash($password){
        return password_hash($password, PASSWORD_DEFAULT, [
            'cost'=>12
        ]);
    }

}
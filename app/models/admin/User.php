<?php

namespace App\models\admin;

use App\models\Model;

class User extends Model {

    protected $table = 'tb_usuario';
    protected $id = 'id_usuario';
    
	const SESSION = "User";
    const ERROR = 'UserError';
    const SUCCESS = 'UserSuccess';
    const ERROR_REGISTER = 'ErrorRegister';

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

    public static function checkLogin($inadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ){
            //Não esta logado
            return false;
        }else{
            if($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true){
                return true;
            }else if($inadmin === false){
                return true;
            }else{
                return false;
            }
        }
    }

}
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

    public static function verifyLogin($inadmin = true){
        if (!User::checkLogin($inadmin)) {
            if ($inadmin) {
                header("Location: ".PATH."/admin/login");
            } else {
                header("Location: ".PATH."/login");
            }
            exit;
        }       
    }

    public function logout(){
        $_SESSION[User::SESSION] = NULL;
    }

    public static function setError($msg){
        $_SESSION[User::ERROR] = $msg;
    }

    public static function getError(){
        $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : "";
        
        User::clearMsgError();

        return $msg;
    
    }

    public static function clearMsgError(){
        $_SESSION[User::ERROR] = null;
    }

    public static function setSuccess($msg){
        $_SESSION[User::SUCCESS] = $msg;
    }

    public static function getSuccess(){
        $msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : "";
        
        User::clearSuccess();

        return $msg;
    
    }

    public static function clearSuccess(){
        $_SESSION[User::SUCCESS] = null;
    }

    public function getPasswordHash($password){
        return password_hash($password, PASSWORD_DEFAULT, [
            'cost'=>12
        ]);
    }

    public function setErrorRegister($msg){
        $_SESSION[User::ERROR_REGISTER] = $msg;
    }

    public static function getErrorRegister(){
        $msg = (isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER]) ? $_SESSION[User::ERROR_REGISTER] : "";
        
        User::clearMsgErrorRegister();

        return $msg;
    
    }

    public static function clearMsgErrorRegister(){
        $_SESSION[User::ERROR_REGISTER] = NULL;
    }

    public function checkLoginExist($login){
        $results = $this->db->select("SELECT * FROM tb_usuario WHERE login = :deslogin", [
            'deslogin'=>$login
        ]);

        return (count($results) > 0);
    }
}
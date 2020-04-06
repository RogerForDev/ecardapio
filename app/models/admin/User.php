<?php

namespace App\models\admin;

use App\models\Model;

class User extends Model {
	protected $table = 'tb_usuario';
	const SESSION = "User";
    const ERROR = 'UserError';
    const SUCCESS = 'UserSuccess';
    const ERROR_REGISTER = 'ErrorRegister';
    const SECRET = "K10nUX_Halifax_S3cr3t";

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

    public function getUsuarioComCodigo($iduser)
    {
        return $this->db->select("SELECT u.*,p.desprofile AS perfil FROM tb_users AS u INNER JOIN tb_profiles AS p ON(p.idprofile = u.idprofile) WHERE u.iduser = :iduser", [
            ':iduser'=>$iduser
        ]);
    }

    public function setPassword($password){
       $results = $this->db->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", [
            ":password"=>$password,
            ":iduser"=>$this->getiduser()
        ]);       
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
        $results = $this->db->select("SELECT * FROM tb_users WHERE deslogin = :deslogin", [
            'deslogin'=>$login
        ]);

        return (count($results) > 0);
    }

    public static function getPage($page = 1, $itensPerPage = 10){
        $start = ($page - 1) * $itensPerPage;

        $results = $this->db->select("SELECT SQL_CALC_FOUND_ROWS *
                        FROM tb_users a 
                        INNER JOIN tb_persons b USING(idperson) 
                        ORDER BY b.desperson
                        LIMIT $start, $itensPerPage;           
        ");

        $resultTotal = $this->db->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            "data"=>$results,
            "total"=>(int)$resultTotal[0]["nrtotal"],
            "pages"=>ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }

    public static function getPageSearch($search, $page = 1, $itensPerPage = 10){
        $start = ($page - 1) * $itensPerPage;

        $results = $this->db->select("SELECT SQL_CALC_FOUND_ROWS *
                        FROM tb_users a 
                        INNER JOIN tb_persons b USING(idperson) 
                        WHERE b.desperson LIKE :search OR b.desemail = :search OR a.deslogin LIKE :search
                        ORDER BY b.desperson
                        LIMIT $start, $itensPerPage;           
        ", [
            ':search'=>'%'.$search.'%'
        ]);

        $resultTotal = $this->db->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            "data"=>$results,
            "total"=>(int)$resultTotal[0]["nrtotal"],
            "pages"=>ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }
}
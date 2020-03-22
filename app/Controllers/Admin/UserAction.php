<?php

namespace App\Controllers\Admin;

use App\Helper as Action;
use App\Model\User;

final class UserAction extends Action
{
    public function index($request, $response)
    {
        $error = User::getError();
        $success = User::getSuccess();

        $users = $this->listAll();

        foreach($users as &$user){
            $user['role'] = 1;
        }
    
        $vars = [
            "page"=>"users/users",		
          //  "title"=>$this->getTemplate()['nome'],
            "users" => $users,      
            "error" => ($error != '')?$error:'',
            "success"=> ($success != '')?$success:''
        ];
    
        return $this->view->render($response, '/admin/index.phtml', $vars);
    }
    public function create($request, $response)
    {
        if(!getPermissionUser("addUser")){
            return $response->withRedirect(PATH.'/admin');
        }
        $user = new User();

        $_POST['inadmin'] = (isset($_POST['inadmin'])) ? 1 : 0;

        $user->setData($_POST);

        try{
            $user->save();
            User::setSuccess("Usuário cadastrado com sucesso.");
        }catch(\Exception $e){
            User::setError("Falha ao salvar usuário");
        }        
        return $response->withRedirect(PATH."/admin/users");        
    }        
    public function update($request, $response){

        if(!getPermissionUser("editUser")){
            return $response->withRedirect(PATH.'/admin');
        }

        $iduser = $request->getAttribute('id');

        if(!is_numeric($iduser)){
            return $response->withRedirect(PATH.'/admin/users');
        }

        $user = new User();

        $user->get((int)$iduser);

        $_POST['inadmin'] = (isset($_POST['inadmin'])) ? 1 : 0;

        $user->setData($_POST);

        try{
            $user->update();
            User::setSuccess("Usuário atualizado com sucesso.");
        }catch(\Exception $e){
            User::setError("Falha ao salvar usuário");
        }
        return $response->withRedirect(PATH.'/admin/users');  
    }
    public function delete($request, $response)
    {   
        if(!getPermissionUser("deleteUser")){
            return $response->withRedirect(PATH.'/admin');
        }
        $iduser = $request->getAttribute('id');
        if(!is_numeric($iduser)){
            return $response->withRedirect(PATH.'/admin/users');
        }
        $user = new User();

        $user->get((int)$iduser);	
    
        $user->delete();

        return $response->withRedirect(PATH.'/admin/users');
    }
    public function updatePassword($request, $response)
    {
        if(!getPermissionUser("editPassword")){
            return $response->withRedirect(PATH.'/admin');
        }
        $iduser = $request->getAttribute('id');
        if(!is_numeric($iduser)){
            return $response->withRedirect(PATH.'/admin/users');
        }
        if (!isset($_POST['despassword']) || $_POST['despassword'] === '') {
            User::setError("Preencha a nova senha.");
            return $response->withRedirect(PATH.'/admin/users');
        }
    
        if (!isset($_POST['despassword-confirm']) || $_POST['despassword-confirm'] === '') {
            User::setError("Preencha a confirmação da nova senha.");
            return $response->withRedirect(PATH.'/admin/users');
        }
    
        if ($_POST['despassword'] !== $_POST['despassword-confirm']) {
            User::setError("Confirme corretamente as senhas.");
            return $response->withRedirect(PATH.'/admin/users');
        }
    
        $user = new User();
    
        $user->get((int)$iduser);

        $user->setPassword(User::getPasswordHash($_POST['despassword']));
    
        User::setSuccess("Senha Alterada com sucesso.");
        return $response->withRedirect(PATH.'/admin/users');
    }

    public function profile($request, $response)
    {
        $vars = [ 
            "page"=>"users/profile"
        ];
        return $this->view->render($response, "/admin/index.phtml", $vars);
    }
    public function listAll(){
        return $this->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
    }
}
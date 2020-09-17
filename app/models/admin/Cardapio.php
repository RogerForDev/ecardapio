<?php

namespace App\models\admin;

use App\models\Model;

class Cardapio extends Model {

    protected $table = 'tb_cardapio';
    protected $id = 'id_cardapio';

    public static function getFromUser(){
        $model = new Cardapio;
        return $model->select()->findBy('id_usuario',User::getFromSession()['id_usuario']);
    }

    public function save_logo($id_cardapio, $logo){
        $sql = "UPDATE tb_cardapio SET logo = :logo WHERE id_cardapio = :id_cardapio";
        $create = $this->connect->prepare($sql);
        $create->execute([
            ":id_cardapio"=>$id_cardapio, 
            ":logo"=> $logo
        ]);
    }
}
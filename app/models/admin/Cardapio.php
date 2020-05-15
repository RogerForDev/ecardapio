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

}
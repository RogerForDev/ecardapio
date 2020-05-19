<?php

namespace App\models\admin;

use App\models\Model;

class Categoria extends Model {

    protected $table = 'tb_categoria';
    protected $id = 'id_categoria';

    public static function getName($id){    
        $cat = new Categoria;
        return $cat->select()->findBy('id_categoria', $id);
    }  
    
    public function getCategByCardapio($id_cardapio){

        $this->sql = "select * from {$this->table} where id_cardapio = {$id_cardapio}";

        return $this->get();
    }
}
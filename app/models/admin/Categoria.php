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
}
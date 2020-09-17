<?php

namespace App\models\admin;

use App\models\Model;

class Tema extends Model {

    protected $table = 'tb_tema';
    public $id = 'id_tema';

    public function getByUsuario($id_usuario){

        $this->sql = "select * from {$this->table} where id_usuario = {$id_usuario} or id_usuario = 0";

        $this->orderBy('id_usuario', 'ASC');

        return $this->get();

    }
    
}
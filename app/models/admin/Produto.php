<?php

namespace App\models\admin;

use App\models\Model;

class Produto extends Model {

    protected $table = 'tb_produto';
    public $id = 'id_produto';

    public function getProdByCardapio($id_cardapio) {
        
		$this->sql = "select a.* from {$this->table} a inner join tb_cardapio_produto b on a.id_produto = b.id_produto where b.id_cardapio = {$id_cardapio}";

        $this->orderBy('a.id_produto', 'DESC');
        
		return $this->get();
    }
    
}
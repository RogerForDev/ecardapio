<?php

namespace App\models\admin;

use App\models\Model;

class Produto extends Model {

    protected $table = 'tb_produto';
    public $id = 'id_produto';

    public function getProdByCardapio($id_cardapio) {
        
		$this->sql = "select a.* from {$this->table} a inner join tb_cardapio_produto b on a.id_produto = b.id_produto where b.id_cardapio = {$id_cardapio}";

        $this->orderBy('a.id_categoria', 'ASC');
        
		return $this->get();
    }

    public function getProdByName($id_cardapio, $filtro, $id_categoria){

        $this->sql = "select a.* from {$this->table} a inner join tb_cardapio_produto b on a.id_produto = b.id_produto where b.id_cardapio = {$id_cardapio} and (a.nome like '%{$filtro}%' or a.descricao like '%{$filtro}%') and a.id_categoria = {$id_categoria}";

        $this->orderBy('a.id_categoria', 'ASC');

        return $this->get();

    }
    
    public function saveProdCardapio($id_cardapio, $id_produto){
        $sql = "INSERT INTO tb_cardapio_produto(id_cardapio, id_produto) VALUES(:id_cardapio, :id_produto)";
        $create = $this->connect->prepare($sql);
        $create->execute([
            ":id_cardapio"=>$id_cardapio,
            ":id_produto"=>$id_produto
        ]);
    }
    
}
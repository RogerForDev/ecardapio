<?php

namespace App\models\admin;

use App\models\Model;

class Produto extends Model {

    protected $table = 'tb_produto';
    public $id = 'id_produto';

    public function getProdByCardapio($id_cardapio) {
        
		$this->sql = "select a.* from {$this->table} a inner join tb_cardapio_produto b on a.id_produto = b.id_produto where b.id_cardapio = {$id_cardapio} and a.ativo = 1";

        $this->orderBy('a.id_categoria', 'ASC');
        
		return $this->get();
    }

    // public function getProdByCardapioActive($id_cardapio){
    //     $sql = "SELECT a.* FROM tb_produto a INNER JOIN tb_cardapio_produto b ON a.id_produto = b.id_produto WHERE b.id_cardapio = {$id_cardapio} AND a.ativo = 1";
    //     $create = $this->connect->prepare($sql);
    //     $create->execute();
    // }

    public function getProdByName($id_cardapio, $filtro, $id_categoria){

        $this->sql = "select a.* from {$this->table} a inner join tb_cardapio_produto b on a.id_produto = b.id_produto where b.id_cardapio = {$id_cardapio} and (a.nome like '%{$filtro}%' or a.descricao like '%{$filtro}%') and a.id_categoria = {$id_categoria} and a.ativo = 1";

        $this->orderBy('a.id_categoria', 'ASC');

        return $this->get();

    }

    public function getProdByCategory($id_categoria){

        $this->sql = "select * from {$this->table} where id_categoria = {$id_categoria} and ativo = 1";

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
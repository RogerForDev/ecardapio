<?php

namespace App\models\admin;

use App\models\Model;

class Admin extends Model {
	protected $table = 'admin';

	public function user() {

		if (!isset($_SESSION['id_admin'])) {
			throw new \Exception("Você não pode acessar essa página");
		}

		$id = $_SESSION['id_admin'];

		$this->sql = "select * from {$this->table}";

		$this->where('id', $id);

		return $this->first();
	}

}

<?php

namespace App\models\admin;

use App\models\Model;

class Post extends Model {
	protected $table = 'posts';

	public function posts() {
		$this->sql = "select *, posts.id as idPost from {$this->table} inner join admin on admin.id = posts.user";

		$this->busca('title,description');

		$this->orderBy('posts.id', 'DESC');

		$this->paginate(20);

		return $this->get();
	}

}

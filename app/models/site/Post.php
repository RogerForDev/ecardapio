<?php

namespace app\models\site;

use app\models\Model;

class Post extends Model {
	protected $table = 'posts';

	public function posts() {
		$this->sql = "select *, posts.id as idPost, posts.photo as postPhoto from {$this->table} inner join admin on admin.id = posts.user";

		$this->busca('title,description');

		$this->orderBy('posts.id', 'DESC');

		$this->paginate(20);

		return $this->get();
	}

}

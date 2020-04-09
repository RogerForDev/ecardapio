<?php


namespace App\models;

use App\controllers\Controller;
use PDO;

class Connection extends Controller {

	public static function connect() {

		$pdo = new PDO("mysql:host=localhost;dbname=ecardapio;charset=utf8", "root","bancodedados");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		return $pdo;
	}

}

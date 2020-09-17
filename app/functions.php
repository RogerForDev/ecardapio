<?php

use App\models\admin\Categoria;
use App\models\admin\User;
use App\src\Flash;
use App\src\Redirect;

function dd($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die();
}

function json($data) {
	header('Content-Type: application/json');

	echo json_encode($data);
}

function path() {
	$vendorDir = dirname(dirname(__FILE__));
	return dirname($vendorDir);
}

function flash($index, $message) {
	Flash::add($index, $message);
}

function error($message) {
    return "<div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>  
                {$message}  
             </div>";
}

function success($message) {
	return "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>  
                {$message}  
             </div>";
}

function message($index){
    echo Flash::get($index);
}

function redirect($target) {
	Redirect::redirect($target);

	die();
}

function back() {
	Redirect::back();
	die();
}

function busca() {
	return filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
}

function checkLogin($inadmin = true)
{
    return User::checkLogin($inadmin);
}

function getUserName(){
    $user = User::getFromSession();

    return $user['nome'];
}
function getNomeCategoria($id){
    $cat = Categoria::getName($id);

    return $cat['nome'];
}

function printAlert($msg, $url){
  return '<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alerta de exclusão</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <i class="fa fa-warning fa-4x text-warning pr-2" aria-hidden="true"></i>
                        <span>'.$msg.'</span>	
                    </div>
                </div>
            </div>
            <div class="modal-footer">																	
                <a href="'.$url.'" class="btn btn-outline-warning">Sim</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>  
  ';  
}

function statusColor($idstatus){
    $class = '';
    switch($idstatus){
        case 1: $class = 'danger';break;
        case 2: $class = 'warning';break;
        case 3: $class = 'success';break;
        case 4: $class = 'primary';break;
    }
    return $class;
}

function array_filter_key( $array, $callback ) {
    $matchedKeys = array_filter(array_keys($array), $callback);
	return array_intersect_key($array, array_flip($matchedKeys));
}

function thumbUrl($path, $size_w = 600, $size_h = 500, $style = '')
{
    if (!$path) return '';
    $ext = explode('.', $path);
    $ext = end($ext);

    if($ext=='png') $path = PATH . "thumb/phpThumb.php?" . "src=" . $path . "&w=$size_w&h=$size_h&zc=1&f=png";
    else $path = PATH . "thumb/phpThumb.php?" . "src=" . $path . "&w=$size_w&h=$size_h&zc=1";
    return $path;
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

?>
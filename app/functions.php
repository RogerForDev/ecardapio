<?php

use \App\Model\User;
use \App\Model\PrivilegedUser;

function setMsg($msg, $type, $key)
{
    switch($type){
        case 'error':
            $_SESSION["Error".$key] = $msg;
            break;
        case 'success':
        $_SESSION["Success".$key] = $msg;
            break;
    }
}

function getMsg($type, $key)
{
    switch($type){
        case 'error':
            $msg = (isset($_SESSION["Error".$key]) && $_SESSION["Error".$key]) ? $_SESSION["Error".$key] : "";			
            $_SESSION["Error".$key] = null;
            return $msg;			
        case 'success':
            $msg = (isset($_SESSION["Success".$key]) && $_SESSION["Success".$key]) ? $_SESSION["Success".$key] : "";			
            $_SESSION["Success".$key] = null;
            return $msg;
    }
}

function clearMsg($type, $key)
{
    switch($type){
        case 'error':
            $_SESSION["Error".$key] = null;
            break;
        case 'success':
            $_SESSION["Success".$key] = null;
            break;
    }
}
function saveImage($width, $height, $dir = null, $fieldName = 'image')
{
    if (!isset($_FILES[$fieldName]['name']) || $_FILES[$fieldName]['error'] != 0) {
        return null;
    }
    if (!($_FILES[$fieldName]['type'] == 'image/jpeg' || $_FILES[$fieldName]['type'] == 'image/png')) {
        return null;
    }
    $datedir = date('Y') . '/' . date('m') . '/' . date('d');
    $dir = is_null($dir) ? null : '/' . $dir;
    $path = DIR_PATH . '/fotos' . $dir . '/';
    $name = md5(rand() . date("His"));
    if (!is_null($dir)) {
        $this->validateDir($path);
    }
    $this->createDayMonthYearDirectory($path);
    $type = $_FILES[$fieldName]['type'] == 'image/jpeg' ? 'jpg' : 'png';
    $imageResize = new ImageResize($_FILES[$fieldName]['tmp_name'], $_FILES[$fieldName]['type']);
    $imageResize->setCropWidthAndHeight($width, $height);
    $imageResize->generateCropImage($path . '/' . $datedir . '/' . $name . '.' . $type);
    return '/fotos' . $dir . '/' . $datedir . '/' . $name . '.' . $type;
}

/**
 * Creates a day, month, year directory if doesn't exists.
 *
 * @param string $path
 *
 * @return boolean
 */
function createDayMonthYearDirectory($path)
{
    if (!is_dir($path . date('Y'))) {
        mkdir($path . date('Y'));
    }
    if (!is_dir($path . date('Y') . '/' . date('m'))) {
        mkdir($path . date('Y') . '/' . date('m'));
    }
    if (!is_dir($path . date('Y') . '/' . date('m') . '/' . date('d'))) {
        mkdir($path . date('Y') . '/' . date('m') . '/' . date('d'));
    }
    return true;
}

/**
 * validate if a directory path exists
 *
 * @param string $path
 *
 * @return boolean
 */
function validateDir($path)
{
    if (!is_dir($path)) {
        mkdir($path);
    }
    return true;
}
 /**
 *  Função para gravar imagem em diretório
 *  @access public 
 *  @param int $limit Limit maximo de arquivos 
 *  @param int $maxSize Tamanho maximo de arquivo
 *  @param String $uploadDir Diretório de upload
 *  @param String $title Nome novo do arquivo      
*/ 
function uploadImage($limit, $maxSize, $uploadDir, $title){   
    $uploader = new Uploader();
    $data = $uploader->upload($_FILES['files'], array(
        'limit' => $limit, //Maximum Limit of files. {null, Number}
        'maxSize' => $maxSize, //Maximum Size of files {null, Number(in MB's)}
        'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
        'required' => false, //Minimum one file is required for upload {Boolean}
        'uploadDir' => $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'fotos'.DIRECTORY_SEPARATOR.$uploadDir.DIRECTORY_SEPARATOR, //Upload directory {String}
        'title' => array($title), //New file name {null, String, Array} *please read documentation in README.md
        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
        'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
    
    if($data['isComplete']){
        $files = $data['data'];
        print_r($files);
    }

    if($data['hasErrors']){
        $errors = $data['errors'];
        print_r($errors);
    }        
    function onFilesRemoveCallback($removed_files){
        foreach($removed_files as $key=>$value){
            $file = $uploadDir . $value;
            if(file_exists($file)){
                unlink($file);
            }
        }            
        return $removed_files;
    }
}
function removeImage($uploadDir){
    if(isset($_POST['file'])){
        $file = $uploadDir . $_POST['file'];
        if(file_exists($file)){
            unlink($file);
        }
    }
}

function formatPrice($vlprice)
{
    if(!$vlprice > 0) $vlprice = 0; 

    return number_format($vlprice, 2, ",", ".");
}

function formatDate($date, $hour = null)
{
    $date = "";
    if($hour){
        $date = date('d/m/Y h:ma');
    }else{
        $date = date('d/m/Y');
    }
    return $date;
}

function checkLogin($inadmin = true)
{
    return User::checkLogin($inadmin);
}

function getUserName(){
    $user = User::getFromSession();

    return $user['desperson'];
}

function getPermissionUser($perm){
    $user = User::getFromSession();
    if (isset($user)) {
       $u =  PrivilegedUser::getByUsername($user['deslogin']); 
       if ($u->hasPrivilege($perm)) {
            return true;
       }else{
           return false;
       }
    }   
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

function getProductByCategory($idcategory, $related = true){
    $category = new Category();

    $category->get((int)$idcategory);

    if($related == true){
        return $category->getProducts();
    }else{
        return $category->getProducts(false);
    }
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

?>
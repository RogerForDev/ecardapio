<?php 
if(isset($_POST['file'])){
    $file = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'fotos'.DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR . $_POST['file'];
    if(file_exists($file)){
        unlink($file);
    }
}
?>
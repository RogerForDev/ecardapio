<?php

namespace App;

class Helper{

    private $container;
    
    function __construct($container)
    {
        $this->container = $container;        
    }
    
    public function __get($property)
    {
        if($this->container->{$property}){
            return $this->container->{$property};
        }    
    }    
    
    public static function getArray($key)
    {
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }
        return $_SESSION[$key];
    }

    private function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            
            $this->bindParam($statement, $key, $value);

        }
    }

    private function bindParam($statement, $key, $value)
    {

        $statement->bindParam($key, $value);

    }

    public function query($rawQuery, $params = array())
    {

        $stmt = $this->db->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

    }

    public function select($rawQuery, $params = array())
    {

        $stmt = $this->db->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }



	
	// public function getTemplate(){

    //     $site = new Site();
    //     $site->get(1);

    //     $theme = new Theme();
    //     $theme->get($site->getidtheme());
    //     //$theme->get(3);
    //     $company = Site::getCompany(1);

    //     $categories = Category::listAll();	

    //     foreach($categories as &$category){
    //         $category['subcategories'] = Category::getSubcategories($category['idcategory']);
    //     }

    //     $cart = Cart::getFromSession();

    //    return $template = [
    //         'nome'       => $site->getdessite(),	
    //         'themes'	 => $theme->getValues() !== null?$theme->getValues():null,
    //         'endereco'   => $company['address'],
    //         'facebook'   => $company['facebook'],
    //         'whatsapp'   => $company['whatsapp'],
    //         'cotacao'    => $company['vldolar'],
    //         'logo'       => $site->getlogo(),	
    //         'categorias' => $categories
    //     ]; 
    // }

}
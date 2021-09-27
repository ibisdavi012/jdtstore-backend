<?php
namespace App\Models;

abstract class ProductModel extends BaseModel {

    public function __construct()
    {
        parent::__construct('eav_products');
    }

    public function findAll() {
        $products = array();
        
        $productList = parent::findAll();

        if ($productList != null) 
        {
        
            for ($index=0; $index < count($productList); $index++) { 
               
                $productType = "App\\Models\\" . ucfirst($productList[$index]['type']);                
               
                $product = !class_exists($productType,true) ? new Product() : new $productType();                    
                
                $product->parse($productList[$index]);

                $products[] = $product;
            }
        
            return $products;
        }        
    }


    public abstract function toArray();

}

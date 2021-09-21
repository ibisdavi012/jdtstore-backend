<?php
namespace App\Models;

abstract class ProductModel extends BaseModel {

    public function __construct()
    {
        parent::__construct('products');
    }

    public function findAll() {
        
        $productList = $this->selectAll();

        if ($productList != null) 
        {
            $products = array();

            for ($index=0; $index < count($productList); $index++) { 
               
                $productType = "App\\Models\\" . ucfirst($productList[$index]['type']);                
               
                $product = !class_exists($productType,true) ? new Product() : new $productType();                    
                
                $product->parse($productList[$index]);

                $products[] = $product->toArray();                                        
            }
        
            return $products;
        }        
    }


    public abstract function toArray();

}

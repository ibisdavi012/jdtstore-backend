<?php
namespace App\Models;

abstract class ProductModel extends BaseModel {
    protected $id;
    
    protected $sku;

    protected $name;
    
    protected $price;

    protected $type;

    public function __construct()
    {
        parent::__construct('products');
    }

    public function findAllProducts() {
        
        $productList = $this->findAll();

        if ($productList != null) 
        {
            $products = array();

            for ($index=0; $index < count($productList); $index++) { 
               
                $productType = "App\\Models\\" . ucfirst($productList[$index]['type']);                
               
                $product = !class_exists($productType,true) ? new Product() : new $productType();                    
                
                $product->parse($productList[$index]);

                $products[] = $product;                                        
            }

            return $products;
        }


        return null;

        
    }

    // ID
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    // SKU
    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function getSku() {
        return $this->sku;
    }

    // Name
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    // Price
    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    // Type
    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

}

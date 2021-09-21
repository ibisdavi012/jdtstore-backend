<?php
namespace App\Models;

class Product extends ProductModel {
    protected $id;
    
    protected $sku;

    protected $name;
    
    protected $price;

    protected $type;

    public function __construct() {
        parent::__construct('products');        
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
        
    
        public function toArray(){
            return array(
                'id' => $this->getId(),
                'sku' => $this->getSku(),
                'name' => $this->getName(),
                'price' => $this->getPrice(),
                'type' => $this->getType()                
            );
        }
    
    public function save(){}
    public function delete(){}
    public function update(){}
}
<?php
namespace App\Models;

class Book extends Product {

    protected $weight = 0;
    
    public function __construct(){
        $this->parseable_attributes = array('id','sku','name','price','type');
        
        $this->custom_attributes = array('weight');

        parent::__construct();
    }   

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }
    
    public function toArray(){
        return array(
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
            'custom_attributes' => array('weight' => $this->getWeight()),
        );
    }

    public function save(){}
    public function delete(){}
    public function update(){}

}
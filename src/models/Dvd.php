<?php
namespace App\Models;

class Dvd extends Product {

    protected $size = 0;
    
    public function __construct(){
        $this->parseable_attributes = array('id','sku','name','price','type');
        
        $this->custom_attributes = array('size');

        parent::__construct();
    }   

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }
    
    public function toArray(){
        return array(
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
            'custom_attributes' => array('size' => $this->getSize()),
        );
    }

    public function findById($id){}
    public function save(){}
    public function delete(){}
    public function update(){}

}
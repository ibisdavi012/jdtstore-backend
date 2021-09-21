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
        
        $attributes =parent::toArray();
        $attributes['size'] = $this->getSize();
        return $attributes;
    }

    public function save(){}
    public function delete(){}
    public function update(){}

}
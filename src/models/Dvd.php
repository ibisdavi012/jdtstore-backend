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
        return $this->setAttribute('size',$size,'Mb');
    }

    public function getSize() {
        return $this->size . "Mb";
    }
    
    public function toArray(){
        
        $attributes =parent::toArray();
        $attributes['size'] = $this->getSize();
        return $attributes;
    }

    public function save(){
        $save_result = $this->execute_query("INSERT INTO products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?,?)",array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType(),
            "{\"size\":{$this->getSize()}}"
        ));
    }
    public function delete(){}
    public function update(){}

}
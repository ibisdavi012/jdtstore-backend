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
        $attributes =parent::toArray();
        $attributes['weight'] = $this->getWeight();
        return $attributes;
    }

    public function save(){}
    public function delete(){}
    public function update(){}

}
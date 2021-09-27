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
             
        return $this->setAttribute('weight',$weight,'Kg');;
    }

    public function getWeight() {
        return $this->weight;
    }
    
    public function toArray(){                        
        $attributes =parent::toArray();
        $attributes['weight'] = $this->getWeight();
        return $attributes;
    }

    public function save(){
        $insert_id = $this->execute_query("INSERT INTO products 
        (sku,name, price, type, custom_attributes) 
    VALUES 
        (?,?,?,?,?)",array(
            $this->getSku(),
            $this->getName(),
            $this->getPrice(),
            $this->getType(),
            "{\"weight\":{$this->getWeight()}}"
        ));

        if($insert_id > 0) {
            $this->setId($insert_id);
            return $insert_id;
        }
        return null;
    }
    public function delete(){}
    public function update(){}

}
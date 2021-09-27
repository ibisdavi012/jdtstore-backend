<?php
namespace App\Models;

class Furniture extends Product {

    protected $height = 0;

    protected $width = 0;
    
    protected $length = 0;
    
    public function __construct(){

        $this->parseable_attributes = array('id','sku','name','price','type');
        
        $this->custom_attributes = array('height','width','length');

        parent::__construct();
    }   
    // Height
    public function setHeight($height) {
        return $this->setAttribute('height',$height,'cm');
    }

    public function getHeight() {
        return $this->height . 'cm';
    }

    // Width
    public function setWidth($width) {
        return $this->setAttribute('width',$width,'cm');
    }

    public function getWidth() {
        return $this->width .'cm';
    }

    // Length
    public function setLength($length) {
        return $this->setAttribute('lenth',$length,'cm');
    }

    public function getLength() {
        return $this->length .'cm';
    }

    public function toArray(){

        $attributes =parent::toArray();
        $attributes['height'] = $this->getHeight();
        $attributes['width'] = $this->getWidth();
        $attributes['length'] = $this->getLength();

        return $attributes;
    }

    public function save(){
        
        $save = $this->execute_query("INSERT INTO eav_products 
                                (sku,name, price, type, custom_attributes) 
                            VALUES 
                                (?,?,?,?,?)",array(
                                    $this->getSku(),
                                    $this->getName(),
                                    $this->getPrice(),
                                    $this->getType(),
                                    "{\"height\":{$this->getHeight()},
                                        \"width\":{$this->getWidth()},
                                        \"length\":{$this->getLength()}}",
                                ));
    }
    public function delete(){}
    public function update(){}

}
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
        $this->height = $height;
    }

    public function getHeight() {
        return $this->height;
    }

    // Width
    public function setWidth($width) {
        $this->width = $width;
    }

    public function getWidth() {
        return $this->width;
    }

    // Length
    public function setLength($length) {
        $this->length = $length;
    }

    public function getLength() {
        return $this->length;
    }

    public function toArray(){

        $attributes =parent::toArray();
        $attributes['height'] = $this->getHeight();
        $attributes['width'] = $this->getWidth();
        $attributes['length'] = $this->getLength();

        return $attributes;
    }

    public function save(){
        

        $this->execute_query("INSERT INTO products 
                                (sku,name, price, type, custom_attributes) 
                            VALUES 
                                (?,?,?,?,?)",array());
    }
    public function delete(){}
    public function update(){}

}
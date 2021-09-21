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
        return array(
            'id' => $this->getId(),
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
            'custom_attributes' => array(
                'height' => $this->getHeight(),
                'width' => $this->getWidth(),
                'length' => $this->getLength())
        );
    }

    public function save(){}
    public function delete(){}
    public function update(){}

}
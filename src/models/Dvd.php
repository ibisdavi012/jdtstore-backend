<?php
namespace App\Models;

class Dvd extends ProductModel {

    protected $size = 0;
    
    public function __construct(){
        $this->parseable_attributes = array('id','sku','name','price','type');
        
        $this->custom_attributes = array('size');

        parent::__construct();
    }   

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize($size) {
        return $this->size;
    }

    public function getById(){}
    public function save(){}
    public function delete(){}
    public function update(){}
}
<?php
namespace App\Models;

class Product extends ProductModel {
    public function __construct() {
        parent::__construct('products');
    }
    public function parse($source){}        
    public function getById(){}
    public function save(){}
    public function delete(){}
    public function update(){}
}
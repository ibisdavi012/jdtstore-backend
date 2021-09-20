<?php
namespace App\Models;

class ProductModel extends BaseModel {
    
    public function __construct() {
        $this->db_table = 'products';
    }
}

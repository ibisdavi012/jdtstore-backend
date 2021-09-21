<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Book;

class ProductController extends BaseController {

    public function __construct() {
    }

    public function GET($id) {
        
        $products = new Product();
    
        if(is_null($id))
        {
            $productList = $products->findAll();
        }
        else{
            $productList = $products->findById($id);
        }
        
        $this->send_response($productList);

    }

    public function POST($id) {
        
    }

    public function DELETE($id) {
    }

   
}
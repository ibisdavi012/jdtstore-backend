<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends BaseController {

    public function __construct() {
    }

    public function GET() {
        $products = new Product();
        
        $productList = $products->findById(2);
        header(HTTP_JSON);        
        echo json_encode($productList);        
    }

    public function POST() {
        
    }

    public function DELETE() {
    }

   
}
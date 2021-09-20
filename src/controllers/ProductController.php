<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends BaseController {

    public function __construct() {
    }

    public function GET() {
        $products = new Product();
        
        $productList = $products->findAllProducts();

        


    }

    public function POST() {
        
    }

    public function DELETE() {
    }

   
}
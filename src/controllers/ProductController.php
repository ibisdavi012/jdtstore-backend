<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController {

    public function __construct() {
    }

    public function GET() {
        $products = new ProductModel();
        $product_list = $products->getAll();
        echo $product_list;
    }

    public function POST() {
    }

    public function DELETE() {
    }

   
}
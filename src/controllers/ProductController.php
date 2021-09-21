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
            $result = $products->findAll();
        }
        else{
            $result = $products->findById($id);
        }        
        
        if(is_null($result)) {
            header(HTTP404);
            exit;
        }

        $this->send_response($result);

    }

    public function POST() {
        $post_body = file_get_contents('php://input');
        
        $attributes = json_decode($post_body,true);
        
        if(is_array($attributes)){        
            $attribute_names = array_keys($attributes);
        }
        else {
            header(HTTP400);
            exit;
        }

        if(in_array("type",$attribute_names)) {
            $type = 'App\\Models\\' . ucfirst($attributes['type']);
            
            if(class_exists($type,true))
            {
                $product = new $type();
                $product->parse($post_body);                
            }
            else {
                header(HTTP400);
                exit;
            }
        } else {
            header(HTTP400);
            exit;
        }        
    }

    public function DELETE($id) {
    }

   
}
<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Book;

class ProductController extends BaseController {

    public function GET($id) {
        
        $products = new Product();
    
        if(is_null($id))
        {                        
            $result = $products->findAll();
            
            if(is_null($result)){            
                $this->send_response('No products were found.',0,null);
            }else {
                $productList[] = array();
                foreach ($products as $product) {
                    $productList[] = $product->toArray();
                }
                
            }
        }
        else{
            $result = $products->findById($id);
            header(HTTP404);
        }        
        

        $this->send_response($result);

    }

    public function POST() {          
        
        $post_body = file_get_contents('php://input');
        
        $attributes = json_decode($post_body,true);
        
        if(!is_array($attributes) || !in_array("type",array_keys($attributes)))
        {
            header(HTTP404);
            exit; 
        }
        
        $type = 'App\\Models\\' . ucfirst($attributes['type']);

        if(class_exists($type,true)){            
            $product = new $type();
            $product->parse($post_body); 
            $product->save();
            $this-send_response('OK');
            
        }
        else {
            header(HTTP400);
            exit; 
        }
    }

    public function DELETE($id) {
    }

   
}
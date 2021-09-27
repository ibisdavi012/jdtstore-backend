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
                $productList = array();
                foreach ($result as $product) {
                    $productList[] = $product->toArray();
                }

                $this->send_response("",count($result),$productList);                
            }
        }
        else{
            $result = $products->findById($id);
            if(is_array($result)){
            $this->send_response("",1,$result);
            }
            else{
                header(HTTP404);
            }
        }        
                
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

            $errors = $product->getErrors();
            
            // ifthe product has wrong values
            if(count($errors) > 0) {
                $this->send_response("Product can't be saved. Please, check input values.", 0, $errors,true);
            }
            else{
                
                $productId = $product->save();

                if($productId) {
                    $this->send_response("The product was saved with id = $productId.", 1, $product->toArray(),false);
                }
                else {
                    $this->send_response("The product could not be saved.", 0, $product->getErrors(),true);
                }
            }            
        }
        else {
            header(HTTP400);
            exit; 
        }
    }

    public function DELETE($id) {
        if(is_null($id))
        {
            $this->send_response("Invalid ID",0,null,true);
        }

        $product = new Product();
        
        $product->setId($id);
        
        if(count($product->getErrors()) > 0 || !$product->delete())
        {
            $this->send_response("Product with id $id was not deleted.", 0, $product->getErrors(),true);            
        }
        else
        {
            $this->send_response($id,1,array('deleted_id'=>$id),false);
        }        
    }

   
}
<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Book;

/**
 * ProductController - This is the Controller that will handle incomming requests to the /products (endpoint)
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
class ProductController extends BaseController
{

    /**
     * Handle GET requests
     *
     * @param  mixed $id
     * @return void
     */
    public function get($id)
    {
        $products = new Product();

        // If no ID is provided, then fetch all products
        if (is_null($id)) {
            $result = $products->findAll();

            // If no records were found, send response
            if (is_null($result)) {
                $this->sendResponse('No products were found.', 0, null);
            } else {
                $productList = array();

                // Convert each product to Array in orther to to pack then togueter before
                // sending them in the Response JSON
                foreach ($result as $product) {
                    $productList[] = $product->toArray();
                }

                // Send the response including the Products
                $this->sendResponse("", count($result), $productList);
            }
        } else {
            // If an ID was provided, then Fetch it and send it in the response
            $result = $products->findById($id);
            if (is_array($result)) {
                $this->sendResponse("", 1, $result);
            } else {
                header(HTTP404);
            }
        }
    }


    /**
     * Handle POST Requests
     *
     * @return void
     */
    public function post()
    {

        $post_body = file_get_contents('php://input');

        $attributes = json_decode($post_body, true);

        // Send HTTP 400 status in case the body of the POST request is not
        // formatted accordingly.
        if (!is_array($attributes) || !in_array("type", array_keys($attributes))) {
            header(HTTP400);
            exit;
        }

        // Define a model that will be load depending of the 'type'
        // field provided in the POST body
        $type = 'App\\Models\\' . ucfirst($attributes['type']);

        // Check if the model class exists, and in case it does create an instance.
        if (class_exists($type, true)) {
            $product = new $type();

            $product->parse($post_body);

            $errors = $product->getErrors();

            // if the product has wrong values
            if (count($errors) > 0) {
                $this->sendResponse("Product can't be saved. Please, check input values.", 0, $errors, true);
            } else {
                $productId = $product->save();

                if ($productId) {
                    $this->sendResponse("The product was saved with id = $productId.", 1, $product->toArray(), false);
                } else {
                    $this->sendResponse("The product could not be saved.", 0, $product->getErrors(), true);
                }
            }
        } else {
            header(HTTP400);
            exit;
        }
    }

    /**
     * Handle DELETE Requests
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        if (is_null($id)) {
            $this->sendResponse("Invalid ID", 0, null, true);
        }

        $product = new Product();

        $product->setId($id);

        if (count($product->getErrors()) > 0 || !$product->delete()) {
            $this->sendResponse("Product with id $id was not deleted.", 0, $product->getErrors(), true);
        } else {
            $this->sendResponse($id, 1, array('deleted_id' => $id), false);
        }
    }

    public function options()
    {
        header("Access-Control-Allow-Origin: https://frosty-darwin-651925.netlify.app");
        header("Access-Control-Allow-Headers: GET, POST, DELETE, OPTIONS");
        header('Content-Type: application/json; charset=utf-8');
    }
}

<?php

namespace App\Controllers;

class ProductController extends BaseController {

    public function __construct() {
        echo 'ProductController::Constructor;';
    }

    public function process_request() {
        echo 'ProductController::process_request()';
    }
}
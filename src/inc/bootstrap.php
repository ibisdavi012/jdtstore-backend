<?php

use App\Routing\Router;

// Enable the PSR-4 Autoload
require_once 'vendor/autoload.php';

// Load App configurations
require_once 'src/inc/config.php';

// Instantiate the router that will dispatch the request to the right Controller
$router = new Router();

// Add Routes (Valid and Protected)
$router->addRoute('products', 'ProductController');

// Dispatch the request to the right Controller
$router->dispatch();

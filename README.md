# Scandiweb Test Assignment

This is a minimal backend project build in PHP and MySQL with an OOP approach without using any frameworks. See more details in the requirement folder.

## How does it work?

It's basically starts with a request which is received by a Router. This router will dispatch the request to the corresponding conroller as defined in src/config/bootstap.php. In This case there is one Controller that handle the requests to the endpoint: http://domain/products

To add a new route, just include the following in the src/config/bootstrap.php file:

    $router->addRoute($endPoint, $controllerName);

The ENDPOINT is in the format:

    /endpoint

For instance, in order to accept requests at /products and dispatch them to the product controller, then you have to write:

    $router->addRoute('products', 'ProductController');


Where the second parameter must be a valid class name.

## The ProductController
It is responsible for properly handling the GET, POST, DELETE and OPTIONS requests. It also extends the BaseController class.

## The models
They are responsible for handling the data, storing and deleting. There are 6 models.

- BaseModel.php
- ProductModel.php
- Product.php
- Book.php
- Furniture.php
- Dvd.php

## Installation
- Copy repository files in the public of your server.
- Execute the sql file database/jdtstore.sql

Make sure to copy the .htaccess because this files contains a rule that redirects al requets to the same endpoint.

## CORS
This projects sends headers to avoid CORS issues.

## User Interfacte
Since it is the backend, there is no UI code. You can check a react project built for this purpose [See React Frontend project](https://github.com/ibisdavi012/jdtstore-ui)

## Live version
There is a live version of the full project. The Frontend is hosted at Netlify, and the backend at InfinityFreeApp.
[See Live version hosted at Netlify](https://frosty-darwin-651925.netlify.app/)

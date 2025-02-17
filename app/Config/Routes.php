<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group("product",["namespace" => "App\Controllers\Api"], function($routes){
    $routes->post("add", "ProductController::addProduct");

    $routes->get("list", "ProductController::listAllProduct");

    $routes->get("/(:num)", "ProductController::getSingleProduct/$1");

    $routes->put("/(:num)", "ProductController::updateProduct/$1");

    $routes->delete("/(:num)", "ProductController::deleteProduct/$1");
});
<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends ResourceController
{
    protected $modelName =  "App\Models\Product";
    protected $format = "json";

    //post - 
    public function addProduct(){

    }

    // get
    public function listAllProducts(){

    }

    // get 
    public function getSingleProduct($product_id){

    }

    // put
    public function updateProduct($product_id){

    }

    //delete
    public function deleteProduct(){

    }
}

<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends ResourceController
{
    protected $modelName =  "App\Models\Product";
    protected $format = "json";

    //post - 
    public function addProduct()
    {
        $validationRules = [
            "title" => [
                "rules" => "required|min_length[3]",
                "errors" => [
                    "required" => "Product title is required",
                    "min_length" => "Title must be greater than 3 character"
                ]
            ],
            "cost" => [
                "rules" => "required|integer|greater_that[0]",
                "errors" => [
                    "required" => "Please provide product cost",
                    "integer" => "Cost must be an integer value",
                    "greater_than" => "Product cost must be greater than 0 value"
                ]
            ],
        ];

        if(!$this->validate($validationRules)){
            return $this->fail($this->validator->getErrors());
        }
    }

    // get
    public function listAllProducts() {}

    // get 
    public function getSingleProduct($product_id) {}

    // put
    public function updateProduct($product_id) {}

    //delete
    public function deleteProduct() {}
}

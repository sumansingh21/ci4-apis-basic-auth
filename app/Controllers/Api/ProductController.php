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
                "rules" => "required|integer|greater_than[0]",
                "errors" => [
                    "required" => "Please provide product cost",
                    "integer" => "Cost must be an integer value",
                    "greater_than" => "Product cost must be greater than 0 value"
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors());
        }

        $imageFile = $this->request->getFile("image");

        if ($imageFile) {  //abc.png
            //File is available.
            $newProductImageName = $imageFile->getRandomName();

            $imageFile->move(FCPATH . "uploads", $newProductImageName);

            $productImageURL = "uploads/" . $newProductImageName;
        } else {
            $productImageURL = null;
        }

        $data = $this->request->getPost();

        $title = $data['title'];
        $cost = $data['cost'];
        $description = isset($data['description']) ? $data['description'] : "";

        if ($this->model->insert([
            "title" => $title,
            "cost" => $cost,
            "description" => $description,
            "product_image" => $productImageURL,
        ])) {
            return $this->respond([
                "status" => true,
                "message" => "Product added successfully"
            ]);
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Failed to add product"
            ]);
        }
    }

    // get
    public function listAllProduct()
    {

        $products = $this->model->findAll();

        if ($products) {
            return $this->respond([
                "status" => true,
                "message" => "Product Found Successfully",
                "product" => $products
            ]);
        } else {
            return $this->respond([
                "status" => true,
                "message" => "Not Product Found.",
            ]);
        }
    }

    // get 
    public function getSingleProduct($product_id)
    {

        $product = $this->model->find($product_id);

        if ($product) {
            return $this->respond([
                "status" => true,
                "message" => "Product Found Successfully",
                "product" => $product
            ]);
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Not Product Found.",
            ]);
        }
    }

    // put
    public function updateProduct($product_id)
    {

        $product = $this->model->find($product_id);

        if ($product) {

            // $data = $this->request->getPost();
            // $data = $this->request->getRawInput();
            // $data = $this->request->getVar();


            // $data = json_decode(file_get_contents("php://input"), true);

            $data['title'] = $this->request->getVar("title");
            $data['cost'] = $this->request->getVar("cost");
            $data['description'] = $this->request->getVar("description");


            $title = isset($data['title']) ? $data['title']  : $product['title'];
            $cost = isset($data['cost']) ? $data['cost'] : $product['cost'];
            $description = isset($data['description']) ? $data['description'] : $product['description'];

            $productImageObject = $this->request->getFile("product_image");

            $productImageURL = $product['product_image'];

            if($productImageObject){
                $newProductImageName = $productImageObject->getRandomName();
                $productImageObject->move(FCPATH . "uploads", $newProductImageName);

                $productImageURL = "uploads/" . $newProductImageName;
            }

          if($this->model->update($product_id,[
            "title" => $title,
            "cost" => $cost,
            "description" => $description,
            "product_image" => $productImageURL
        ])){
            return $this->respond([
                "status" => true,
                "message" => "Product Updated Suuccessfully.",
                "data" => $data
            ]);
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Failed to Product Updated.",
            ]);
        }
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Product Not Found",
            ]);
        }
    }

    //delete
    public function deleteProduct($product_id) {
        $product = $this->model->find($product_id);

        if($product){
           if($this->model->delete($product_id)) {
                return $this->respond([
                    "status" => true,
                    "message" => "Product deleted successfully"
                ]);
           } else {
            return $this->respond([
                "status" => false,
                "message" => "Failed to Product deleted."
            ]);
           }
        } else {
            return $this->respond([
                "status" => false,
                "message" => "Product not found."
            ]);
        }
        }
}

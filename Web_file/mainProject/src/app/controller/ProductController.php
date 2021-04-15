<?php

namespace app\controller;

require_once('src/app/model/User.php');
require_once('src/app/model/Product.php');
use app\model\User;
use app\model\Product;

class ProductController extends CommonController
{
    protected $controllerName = 'product';

    public function actionCreate()
    {
        $this->title = "Új elem hozzáadása";
        
        if (isset($_POST['product']) && isset($_SESSION['user_id']))
        {
            $product = new Product();
            $product->setName($_POST['product']['name']);
            $error = false;
            if(!$product->addNewProduct($product->getName()))
            {
                $error = true;
            }
            if(!$error)
            {
                echo json_encode([
                    "success" => !$error,
                    "data" => [
                        "name" => $product->getName(),
                        "id" => $product->getId()
                    ]
                ]);
                exit();
            }
            else {
                echo json_encode([
                    "success" => $error,
                    "data" => []
                ]);
                exit();
            }
        }

        return $this->render("create", [
            "product" => $product
        ]);
    }
}
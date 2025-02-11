<?php

namespace Src\Modules\Product;

use DatabaseConnection\OrderBy;

class ProductService
{
    use TraitSuportProduct;
    public function __construct($requestParams = [], $bodyParams = [])
    {
        $this->requestParams = $requestParams;
        $this->bodyParams = $bodyParams;
    }

    public function listAll()
    {
        $products = Product::findObjects();
        return $products;
    }

    public function store(): Product
    {
        $product = $this->arrayDataToProduct();
        $product->store();
        return $product;
    }

    public function update(): Product
    {
        $product = $this->getProductToUpdate($this->requestParams['idProduct']);
        $product->update();
        return $product;
    }

    public function delete(): Product
    {
        $product = $this->findProductById($this->requestParams['idProduct']);
        $product->delete();
        return $product;
    }
}
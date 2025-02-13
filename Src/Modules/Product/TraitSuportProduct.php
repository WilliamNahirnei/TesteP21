<?php

namespace Src\Modules\Product;

use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;

trait TraitSuportProduct
{
    protected function arrayDataToProduct(): Product
    {
        return new Product(
            $this->bodyParams['name'],
            $this->bodyParams['value']
        );
    }
    protected function getProductToUpdate(int $idProduct): Product
    {
        $product = $this->findProductById($idProduct);
        if (!empty($this->bodyParams['name'])) {
            $product->setProductName($this->bodyParams['name']);
        }
        if (!empty($this->bodyParams['value'])) {
            $product->setProductValue($this->bodyParams['value']);
        }
        return $product;
    }

    protected function findProductById(int $idProduct): Product
    {
        $product = Product::findById($idProduct);
        if (empty($product)) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Produto não encontrado"], StatusCodes::HTTP_NOT_FOUND);
        }
        return $product;
    }
}
<?php

namespace Src\Modules\Product;

use Server\Constants\StatusCodes;
use Server\Router\Request;
use Server\Router\Response;
use Src\Suport\TraitModelResponse;

class ProductController
{
    use TraitModelResponse;


    /**
     * @return array
     * @throws \Throwable
     */
    public function list(): array
    {
        try {
            $service                = new ProductService();
            $returnData = $service->listAll();
            return self::modelListToArrayResponse($returnData);
        } catch (\Throwable $error) {
            throw $error;
        }

    }


    /**
     *
     * Creates a product with request data.
     *
     * @return \stdClass An object representing the created product.
     */
    public function store(): \stdClass
    {
        try {
            Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Produto cadastrado com sucesso!');
            $service                = new ProductService(
                null,
                Request::getInstance()
                       ->getBodyParams()
            );
            $returnData             = new \stdClass();
            $returnData->idProduct = $service->store()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }

    }

    /**
     *
     * Update a product with request data.
     *
     * @return \stdClass An object representing the updated product.
     */
    public function update(): Product {
        try {
            //                Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Produto atualizado com sucesso!');
            $service = new ProductService(Request::getInstance()->getQueryParams(), Request::getInstance()->getBodyParams());
            $returnData = new \stdClass();
            $product = $service->update();
            return $product;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete(): \stdClass
    {
        try {
            Response::setResponseMessage('produto deletado com sucesso!');
            $service = new ProductService(Request::getInstance()->getQueryParams());
            $returnData = new \stdClass();
            $returnData->idProduct = $service->delete()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

}
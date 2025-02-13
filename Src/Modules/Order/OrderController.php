<?php

namespace Src\Modules\Order;

use Server\Constants\StatusCodes;
use Server\Router\Request;
use Server\Router\Response;
use Src\Suport\TraitModelResponse;

class OrderController
{
    use TraitModelResponse;


    /**
     * @return array
     * @throws \Throwable
     */
    public function list(): array
    {
        try {
            $service                = new OrderService();
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
            Response::setResponseMessage('Pedido criado com sucesso!');
            $service                = new OrderService(
                null,
                Request::getInstance()
                       ->getBodyParams()
            );
            $returnData             = new \stdClass();
            $returnData->idOrder = $service->store()->getId();
            return $returnData;
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
    public function importFile(): \stdClass
    {
        try {
            Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Pedidos criados com sucesso!');
            $service                = new OrderService(
                null,
                Request::getInstance()
                       ->getBodyParams()
            );
            $returnData             = new \stdClass();
            $service->importFile();
//            $returnData->idOrder = $service->store()->getId();
            $returnData->idOrder = 0;
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
    public function update(): Order {
        try {
            Response::setResponseMessage('pedido atualizado com sucesso!');
            $service = new OrderService(Request::getInstance()->getQueryParams(), Request::getInstance()->getBodyParams());
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
            Response::setResponseMessage('Pedido deletado com sucesso!');
            $service = new OrderService(Request::getInstance()->getQueryParams());
            $returnData = new \stdClass();
            $returnData->idOrder = $service->delete()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

}
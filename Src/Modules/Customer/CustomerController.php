<?php

namespace Src\Modules\Customer;

use Server\Constants\StatusCodes;
use Server\Router\Request;
use Server\Router\Response;
use Src\Suport\TraitModelResponse;

class CustomerController
{
    use TraitModelResponse;

    /**
     * @return array
     * @throws \Throwable
     */
    public function list(): array
    {
        try {
            $service                = new CustumerService();
            $returnData = $service->listAll();
            return self::modelListToArrayResponse($returnData);
        } catch (\Throwable $error) {
            throw $error;
        }

    }
    /**
     * @return array
     * @throws \Throwable
     */
    public function find(): array
    {
        try {
            $service                = new CustumerService(Request::getInstance()->getQueryParams());
            $customer = $service->find();
            return $customer->toArray();
        } catch (\Throwable $error) {
            throw $error;
        }

    }

    /**
     *
     * Creates a customer with request data.
     *
     * @return \stdClass An object representing the created custumer.
     */
    public function store(): \stdClass
    {
        try {
            Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Cliente cadastrado com sucesso!');
            $service                = new CustumerService(
                null,
                Request::getInstance()
                       ->getBodyParams()
            );
            $returnData             = new \stdClass();
            $returnData->idCustomer = $service->store()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }

    }

    /**
     *
     * Update a customer with request data.
     *
     * @return \stdClass An object representing the updated custumer.
     */
    public function update(): array {
        try {
//                Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Cliente atualizado com sucesso!');
            $service = new CustumerService(Request::getInstance()->getQueryParams(), Request::getInstance()->getBodyParams());
            $custumer = $service->update();
            return $custumer->toArray();
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete(): \stdClass
    {
        try {
            Response::setResponseMessage('Cliente deletado com sucesso!');
            $service = new CustumerService(Request::getInstance()->getQueryParams());
            $returnData = new \stdClass();
            $returnData->idCustomer = $service->delete()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

}
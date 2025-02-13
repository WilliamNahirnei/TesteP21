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
            $service                = new CustomerService();
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
            $service                = new CustomerService(Request::getInstance()->getQueryParams());
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
     * @return \stdClass An object representing the created customer.
     */
    public function store(): array
    {
        try {
            Response::setStatusCode(StatusCodes::HTTP_CREATED);
            Response::setResponseMessage('Cliente cadastrado com sucesso!');
            $service                = new CustomerService(
                null,
                Request::getInstance()
                       ->getBodyParams()
            );
            return $service->store()->toArray();
        } catch (\Throwable $error) {
            throw $error;
        }

    }

    /**
     *
     * Update a customer with request data.
     *
     * @return \stdClass An object representing the updated customer.
     */
    public function update(): array {
        try {
            Response::setResponseMessage('Cliente atualizado com sucesso!');
            $service = new CustomerService(Request::getInstance()->getQueryParams(), Request::getInstance()->getBodyParams());
            $customer = $service->update();
            return $customer->toArray();
        } catch (\Throwable $error) {
            throw $error;
        }
    }

    public function delete(): \stdClass
    {
        try {
            Response::setResponseMessage('Cliente deletado com sucesso!');
            $service = new CustomerService(Request::getInstance()->getQueryParams());
            $returnData = new \stdClass();
            $returnData->idCustomer = $service->delete()->getId();
            return $returnData;
        } catch (\Throwable $error) {
            throw $error;
        }
    }

}
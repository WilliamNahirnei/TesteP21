<?php

namespace Src\Modules\Customer;

class CustomerService
{
    use TraitSuportCustomer;
    public function __construct($requestParams = [], $bodyParams = [])
    {
        $this->requestParams = $requestParams;
        $this->bodyParams = $bodyParams;
    }

    public function find()
    {
        $customers = $this->findCustomerById($this->requestParams['idCustumer']);
        return $customers;
    }
    public function listAll()
    {
        $customers = Customer::findObjects();
        return $customers;
    }

    public function store(): Customer
    {
        $customer = $this->arrayDataToCustomer();
        $customer->store();
        return $customer;
    }

    public function update(): Customer
    {
        $customer = $this->getCustomerToUpdate($this->requestParams['idCustumer']);
        $customer->update();
        return $customer;
    }

    public function delete(): Customer
    {
        $customer = $this->findCustomerById($this->requestParams['idCustumer']);
        $customer->delete();
        return $customer;
    }
}
<?php

namespace Src\Modules\Customer;

use DatabaseConnection\WhereCondition;
use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;

trait TraitSuportCustomer
{
    protected function arrayDataToCustomer(): Customer
    {
        $customer = new Customer(
            $this->bodyParams['name'],
            $this->bodyParams['email']
        );
        $customer->setCustomerLocation($this->bodyParams['location']);

        return $customer;
    }
    protected function getCustomerToUpdate(int $idCustomer): Customer
    {
        $customer = $this->findCustomerById($idCustomer);
        if (!empty($this->bodyParams['name'])) {
            $customer->setCustomerName($this->bodyParams['name']);
        }
        if (!empty($this->bodyParams['email'])) {
            $customer->setCustomerEmail($this->bodyParams['email']);
        }
        if (!empty($this->bodyParams['location'])) {
            $customer->setCustomerLocation($this->bodyParams['location']);
        }
        return $customer;
    }

    protected function findCustomerById(int $idCustomer): Customer
    {
        $customer = Customer::findById($idCustomer);
        if (empty($customer)) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Cliente não encontrado"], StatusCodes::HTTP_NOT_FOUND);
        }
        return $customer;
    }

    protected function findOrInsertCustomerByStd(\stdClass $stdCustomer): ?Customer
    {
        $customer = null;
        if ($stdCustomer->externalId) {
            $whereExternalId = new WhereCondition(Customer::COLUMN_EXTERNAL_ID, "=", $stdCustomer->externalId);
            $customer = Customer::findOne(null, [], [$whereExternalId]);
        }

        if ($stdCustomer->customerEmail) {
            $whereEmail = new WhereCondition(Customer::COLUMN_EMAIL, "=", $stdCustomer->customerEmail);
            $customer = Customer::findOne(null, [], [$whereEmail]);
        }

        if ($stdCustomer->customerName) {
            $whereName = new WhereCondition(Customer::COLUMN_NAME, "=", $stdCustomer->customerName);
            $customer = Customer::findOne(null, [], [$whereName]);
        }

        if (empty($customer)) {
            $customer = new Customer($stdCustomer->customerName, $stdCustomer->customerEmail);
            $customer->setExternalId($stdCustomer->externalId);
            $customer->setCustomerLocation($stdCustomer->location);
            $customer->store();
        }
        return $customer;
    }
}
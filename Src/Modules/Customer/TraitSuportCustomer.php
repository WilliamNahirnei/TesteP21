<?php

namespace Src\Modules\Customer;

use DatabaseConnection\WhereCondition;

trait TraitSuportCustomer
{
    protected function arrayDataToCustomer(): Customer
    {
        return new Customer(
            $this->bodyParams['name'],
            $this->bodyParams['email']
        );
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
        return $customer;
    }

    protected function findCustomerById(int $idCustomer): Customer
    {
        $customer = Customer::findById($idCustomer);
        if (empty($customer)) {
            //LancarErro
        }
        return $customer;
    }

    protected function findOrInsertCustomerByStd(\stdClass $stdCustomer): ?Customer
    {
        $customer = null;
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
            $customer->store();
        }
        return $customer;
    }
}
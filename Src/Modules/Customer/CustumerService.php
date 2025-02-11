<?php

namespace Src\Modules\Customer;

class CustumerService
{
    use TraitSuportCustumer;
    public function __construct($requestParams = [], $bodyParams = [])
    {
        $this->requestParams = $requestParams;
        $this->bodyParams = $bodyParams;
    }

    public function listAll()
    {
        $custumers = Custumer::findObjects();
        return $custumers;
    }

    public function store(): Custumer
    {
        $custumer = $this->arrayDataToCustumer();
        $custumer->store();
        return $custumer;
    }

    public function update(): Custumer
    {
        $custumer = $this->getCustumerToUpdate($this->requestParams['idCustumer']);
        $custumer->update();
        return $custumer;
    }

    public function delete(): Custumer
    {
        $custumer = $this->findCustumerById($this->requestParams['idCustumer']);
        $custumer->delete();
        return $custumer;
    }
}
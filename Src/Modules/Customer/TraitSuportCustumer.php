<?php

namespace Src\Modules\Customer;

trait TraitSuportCustumer
{
    protected function arrayDataToCustumer(): Custumer
    {
        return new Custumer(
            $this->bodyParams['name'],
            $this->bodyParams['email']
        );
    }
    protected function getCustumerToUpdate(int $idCustumer): Custumer
    {
        $custumer = $this->findCustumerById($idCustumer);
        if (!empty($this->bodyParams['name'])) {
            $custumer->setCustumerName($this->bodyParams['name']);
        }
        if (!empty($this->bodyParams['email'])) {
            $custumer->setCustumerEmail($this->bodyParams['email']);
        }
        return $custumer;
    }

    protected function findCustumerById(int $idCustumer): Custumer
    {
        $custumer = Custumer::findById($idCustumer);
        if (empty($custumer)) {
            //LancarErro
        }
        return $custumer;
    }
}
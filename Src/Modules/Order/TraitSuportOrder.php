<?php

namespace Src\Modules\Order;

use Src\Modules\Customer\TraitSuportCustumer;

trait TraitSuportOrder
{
    use TraitSuportCustumer;
    protected function arrayDataToOrder(): Order
    {
        $order = new Order(
            $this->bodyParams['observations'],
        );

        $order->setCustumer($this->findCustumerById($this->bodyParams['idCustomer']));

        return $order;
    }
    protected function getOrderToUpdate(int $idOrder): Order
    {
        $order = $this->findOrderById($idOrder);
        if (!empty($this->bodyParams['observations'])) {
            $order->setOrderObservations($this->bodyParams['observations']);
        }
        return $order;
    }

    protected function findOrderById(int $idOrder): Order
    {
        $order = Order::findById($idOrder);
        if (empty($order)) {
            //LancarErro
        }
        return $order;
    }
}
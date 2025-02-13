<?php

namespace Src\Modules\Order;

use Src\Modules\Customer\TraitSuportCustomer;

trait TraitSuportOrder
{
    use TraitSuportCustomer;
    protected function arrayDataToOrder(): Order
    {
        $order = new Order(
            $this->bodyParams['observations'],
        );

        $order->setCustomer($this->findCustomerById($this->bodyParams['idCustomer']));

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

    protected function xlsDataToStd($xlsStd): array
    {
        $indexMapper = IndexMapXLSXToStd::getArrayXLSXColumnToAtributeName();

        $orderStdList = [];

        foreach ($xlsStd->data as $row) {
            $orderStd = new \stdClass();
            foreach ($indexMapper as $index => $columnStd) {
                $indexOfData = $xlsStd->headers[$index];
                $orderStd->{$columnStd} = $row[$indexOfData] ?? null;
            }
            $orderStdList[] = $orderStd;
        }
        return $orderStdList;
    }

    protected function insertOrdersStdList($listOrderStd)
    {
        foreach ($listOrderStd as $orderStd) {
            $customer = $this->findOrInsertCustomerByStd($orderStd);
            $order = $this->stdOrderToOrder($orderStd);
            $order->setCustomer($customer);
            $order->store();
        }
    }

    protected function stdOrderToOrder(\stdClass $orderStd)
    {
        $order = new Order(
            $orderStd->products,
            (float)$orderStd->orderValue,
            new \DateTime($orderStd->dateOrder),
        );
        return $order;
    }
}
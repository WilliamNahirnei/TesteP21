<?php

namespace Src\Modules\Order;

class OrderService
{
    use TraitSuportOrder;
    public function __construct($requestParams = [], $bodyParams = [])
    {
        $this->requestParams = $requestParams;
        $this->bodyParams = $bodyParams;
    }

    public function listAll()
    {
        $orders = Order::findObjects();
        return $orders;
    }

    public function store(): Order
    {
        $order = $this->arrayDataToOrder();
        $order->store();
        return $order;
    }

    public function update(): Order
    {
        $order = $this->getOrderToUpdate($this->requestParams['idOrder']);
        $order->update();
        return $order;
    }

    public function delete(): Order
    {
        $order = $this->findOrderById($this->requestParams['idOrder']);
        $order->delete();
        return $order;
    }
}
<?php

namespace Src\Modules\Order;

use Src\Suport\TraitSuportXlSX;

class OrderService
{
    use TraitSuportOrder;
    use TraitSuportXlSX;
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
    public function importFile()
    {
        $fileData = $this->XLSXBase64ToArray($this->bodyParams['base64File']);
        $listOrderStd = $this->xlsDataToStd($fileData);
        $this->insertOrdersStdList($listOrderStd);
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
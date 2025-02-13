<?php

namespace Src\Modules\Order;

use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;
use Src\Modules\Customer\TraitSuportCustomer;
use Src\Suport\TraitSuportXlSX;
use Src\Suport\TraitSuportXml;

trait TraitSuportOrder
{
    use TraitSuportCustomer;
    use TraitSuportXlSX;
    use TraitSuportXml;
    protected function arrayDataToOrder(): Order
    {
        $order = new Order(
            $this->bodyParams['observations'],
            $this->bodyParams['totalValue'],
        );

        $order->setOrderStatus('pendente');

        $order->setOrderLocation($this->bodyParams['location']);
        $order->setCustomer($this->findCustomerById($this->bodyParams['idCustomer']));

        return $order;
    }
    protected function getOrderToUpdate(int $idOrder): Order
    {
        $order = $this->findOrderById($idOrder);
        if (!empty($this->bodyParams['observations'])) {
            $order->setOrderObservations($this->bodyParams['observations']);
        }
        if (!empty($this->bodyParams['totalValue'])) {
            $order->setOrderTotalValue($this->bodyParams['totalValue']);
        }
        if (!empty($this->bodyParams['location'])) {
            $order->setOrderLocation($this->bodyParams['location']);
        }
        if (!empty($this->bodyParams['status'])) {
            $order->setOrderStatus($this->bodyParams['status']);
        }
        return $order;
    }

    protected function findOrderById(int $idOrder): Order
    {
        $order = Order::findById($idOrder);
        if (empty($order)) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Pedido identificador $idOrder. Não encontrado"], StatusCodes::HTTP_NOT_FOUND);
        }
        return $order;
    }

    protected function insertFileOrders()
    {
        $fileExtension = $this->bodyParams['fileExtension'];
        switch ($fileExtension) {
            case 'xlsx':
                $this->insertXlsxFileOrders($this->bodyParams['base64File']);
                break;
            case 'xml':
                $this->inserXmlFileOrders($this->bodyParams['base64File']);
                break;
                default:
                    throw new ApiException(true, ApiExceptionTypes::ERROR, ["Arquvio de pedidos tipo $fileExtension não suportado"], StatusCodes::HTTP_NOT_FOUND);
        }
    }

    protected function insertXlsxFileOrders($base64File)
    {
        $fileData = $this->XLSXBase64ToArray($base64File);
        $listOrderStd = $this->xlsDataToStd($fileData);
        $this->insertOrdersStdList($listOrderStd);
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

    protected function stdOrderToOrder(\stdClass $orderStd)
    {
        $orderObservation = $orderStd->products;
        if (!empty($orderStd->productAmount)) {
            $orderObservation .= ". QTD: $orderStd->productAmount";
        }
        $order = new Order(
            $orderObservation,
            (float)$orderStd->orderValue,
            $orderStd->dateOrder,
        );
        $order->setOrderLocation($orderStd->location);
        $order->setOrderStatus('entregue');

        return $order;
    }

    protected function inserXmlFileOrders($base64File)
    {
        $fileData = $this->XMLBase64ToArray($base64File);
        $orderStdList = $this->xmlDataOrderToStd($fileData);
        $this->insertOrdersStdList($orderStdList);

    }

    protected function xmlDataOrderToStd($xml): array
    {
        $indexMapper = IndexMapXmlToStd::getArrayXMLColumnToAtributeName();

        $orderStdList = [];

        foreach ($xml as $xmlOrder) {
            $orderStd = new \stdClass();
            foreach ($indexMapper as $index => $columnStd) {
                $orderStd->{$columnStd} = $xmlOrder->{$index} ?? null;
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
}
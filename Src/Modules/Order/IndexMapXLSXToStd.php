<?php

namespace Src\Modules\Order;

class IndexMapXLSXToStd
{

    // XLSX COLUMNS
    const XLSX_EXTERNAL_ID = "ID Cliente";
    const XLSX_NAME = "Nome";
    const XLSX_EMAIL = "E-mail";
    const XLSX_PRODUCTS = "Histórico de Pedidos";
    const XLSX_DATE_ORDER = "Data Último Pedido";
    const XLSX_VALUE = "Valor Último Pedido ($)";

    //ATRIBUTES NAME STD

    const EXTERNAL_ID = "externalId";
    const NAME = "customerName";
    const EMAIL = "customerEmail";
    const PRODUCTS = "products";
    const DATE_ORDER = "dateOrder";
    const VALUE = "orderValue";
    public static function getArrayXLSXColumnToAtributeName()
    {
        return [
            self::XLSX_EXTERNAL_ID => self::EXTERNAL_ID,
            self::XLSX_NAME => self::NAME,
            self::XLSX_EMAIL => self::EMAIL,
            self::XLSX_PRODUCTS => self::PRODUCTS,
            self::XLSX_DATE_ORDER => self::DATE_ORDER,
            self::XLSX_VALUE => self::VALUE,
        ];
    }
}
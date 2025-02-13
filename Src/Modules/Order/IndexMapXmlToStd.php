<?php

namespace Src\Modules\Order;

class IndexMapXmlToStd
{

    // XML COLUMNS
    const XML_EXTERNAL_ID = "id_loja";
    const XML_NAME = "nome_loja";
    const XML_EMAIL = "";
    const XML_LOCATION = "localizacao";
    const XML_PRODUCT = "produto";
    const XML_PRODUCT_AMOUNT = "quantidade";
    const XML_DATE_ORDER = "";
    const XML_VALUE = "";

    //ATRIBUTES NAME STD

    const EXTERNAL_ID = "externalId";
    const NAME = "customerName";
//    const EMAIL = "customerEmail";
    const LOCATION = "location";

    const PRODUCTS = "products";
    const PRODUCT_AMOUNT = "productAmount";
    const DATE_ORDER = "dateOrder";
    const VALUE = "orderValue";
    public static function getArrayXMLColumnToAtributeName()
    {
        return [
            self::XML_EXTERNAL_ID => self::EXTERNAL_ID,
            self::XML_NAME => self::NAME,
//            self::XML_EMAIL => self::EMAIL,
            self::XML_LOCATION => self::LOCATION,
            self::XML_PRODUCT => self::PRODUCTS,
            self::XML_PRODUCT_AMOUNT => self::PRODUCT_AMOUNT,
//            self::XML_DATE_ORDER => self::DATE_ORDER,
//            self::XML_VALUE => self::VALUE,
        ];
    }
}
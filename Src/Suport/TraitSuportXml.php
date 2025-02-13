<?php

namespace Src\Suport;

use Server\Constants\ApiExceptionTypes;
use Server\Constants\StatusCodes;
use Server\Errors\ApiException;

trait TraitSuportXml
{
    function xmlBase64ToArray($base64File) {
        // Decodifica o Base64
        $xmlContent = base64_decode($base64File);
        if (!$xmlContent) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Erro ao decodificar o XML Base64."], StatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Carrega o XML a partir da string
        $xml = simplexml_load_string($xmlContent);
        if (!$xml) {
            throw new ApiException(true, ApiExceptionTypes::ERROR, ["Erro ao carregar o XML."], StatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $xml;
    }
}
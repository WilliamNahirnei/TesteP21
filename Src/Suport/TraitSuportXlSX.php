<?php

namespace Src\Suport;

trait TraitSuportXlSX
{
    function XLSXBase64ToArray($base64File): \stdClass
    {
        $registerArray = $this->generateXLSXBase64Array($base64File);
        $headersIndex = array_flip(array_shift($registerArray));
        $xlsxData = new \stdClass();
        $xlsxData->headers = $headersIndex;
        $xlsxData->data = $registerArray;
        return $xlsxData;
    }
    function generateXLSXBase64Array($base64File)
    {
        // Decodifica o Base64
        $fileData = base64_decode($base64File);
        if (!$fileData) {
//            "Falha ao decodificar o Base64."
        }

        // Salva o arquivo temporariamente
        $tempFilePath = tempnam(sys_get_temp_dir(), 'upload_') . ".xlsx";
        file_put_contents($tempFilePath, $fileData);

        // Extrai os arquivos internos do XLSX (que é um ZIP)
        $zip = new \ZipArchive();
        if ($zip->open($tempFilePath) === TRUE) {
            $zip->extractTo(sys_get_temp_dir() . "/xlsx_extracted");
            $zip->close();
        } else {
//            "Falha ao extrair o arquivo ZIP."
        }

        $extractPath = sys_get_temp_dir() . "/xlsx_extracted/";

        // Lê o arquivo `xl/sharedStrings.xml` para obter strings compartilhadas
        $sharedStrings = [];
        if (file_exists($extractPath . "xl/sharedStrings.xml")) {
            $xml = simplexml_load_file($extractPath . "xl/sharedStrings.xml");
            foreach ($xml->si as $string) {
                $sharedStrings[] = (string) $string->t;
            }
        }

        // Lê a planilha principal `xl/worksheets/sheet1.xml`
        $sheetFile = $extractPath . "xl/worksheets/sheet1.xml";
        if (!file_exists($sheetFile)) {
            //Arquivo da planilha não encontrado."
        }

        // Remove os arquivos temporários
        unlink($tempFilePath);
        array_map('unlink', glob("$extractPath/*"));
        rmdir($extractPath);

        $xml = simplexml_load_file($sheetFile);
        $data = [];

        foreach ($xml->sheetData->row as $row) {
            $register = [];
            $cellIndex = 0;

            foreach ($row->c as $cell) {
                // Obtém a referência da célula (ex: "A1", "B2", etc.)
                $cellRef = (string) $cell['r'];

                // Extrai a parte da coluna da referência (ex: "A" de "A1", "B" de "B2")
                $columnLetter = preg_replace('/[0-9]/', '', $cellRef);

                // Converte a letra da coluna para um índice numérico (A=0, B=1, C=2, ...)
                $columnIndex = columnLetterToIndex($columnLetter);

                // Obtém o valor da célula
                $value = isset($cell->v) ? (string) $cell->v : null;

                // Se for uma string compartilhada, pega o valor correto
                if (isset($cell['t']) && $cell['t'] == 's') {
                    $value = $sharedStrings[$value] ?? $value;
                }

                // Garante que as colunas ausentes sejam preenchidas com null
                while ($cellIndex < $columnIndex) {
                    $register[$cellIndex] = null;
                    $cellIndex++;
                }

                // Adiciona o valor correto na posição certa
                $register[$columnIndex] = $value;
                $cellIndex++;
            }

            $data[] = $register;
        }

        return $data;
    }
}

function columnLetterToIndex($columnLetter) {
    $columnIndex = 0;
    $length = strlen($columnLetter);

    for ($i = 0; $i < $length; $i++) {
        $columnIndex *= 26;
        $columnIndex += ord($columnLetter[$i]) - ord('A') + 1;
    }

    return $columnIndex - 1; // Ajuste para começar do índice 0
}
<?php

// include_once(__ROOT__ . '/vendor/PhpSpreadsheet/Psr/autoloader.php');
include_once(__ROOT__ . '/vendor/PhpSpreadsheet/autoloader.php');

/**
 * Operações com planilhas e arquivos.
 */
class PhpSpreadsheetService
{
    /**
     * Carrega arquivo e retorna linhas e colunas.
     * https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/#looping-through-cells-using-iterators
     */
    function loadfile($file) {
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        return $rows;
    }
}
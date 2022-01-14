<?php
namespace TPPA\APP\service;

// TODO: COMO INCLUIR essas dependências.
include __ROOT__ . '/app/vendor/PhpSpreadsheet/PhpSpreadsheet/Spreadsheet.php';
include __ROOT__ . '/app/vendor/PhpSpreadsheet/autoloader.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

use function TPPA\CORE\basic\pr;

// include_once(__ROOT__ . '/vendor/PhpSpreadsheet/autoloader.php');

/**
 * Operações com planilhas e arquivos.
 */
class PhpSpreadsheetService
{
    /**
     * Carrega arquivo e retorna linhas e colunas.
     * https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/#looping-through-cells-using-iterators
     */
    function loadFile($file) {
        
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

    /**
     * Cria arquivo
     * https://phpspreadsheet.readthedocs.io/en/latest/topics/accessing-cells/#looping-through-cells-using-iterators
     */
    function saveFile($data, $file_name) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $column = [];
        $row = 1;


        foreach($data as $key => $value) {
            if($key == 0) {
                // array com nome das colunas.
                $header = array_keys((array) $value);
                $char = 'A';
                foreach($header as $header_value) {
                    $column[$char] = $header_value;
                    $sheet->setCellValue($char.($row), $header_value);
                    $char++;
                }
            }
            $row++; // proxima linha
            foreach($column as $column_char => $column_value) {
                $row_value = isset($value->{$column_value}) ? $value->{$column_value} : "";
                $sheet->setCellValue($column_char.$row, $row_value);
            }
        }

        $writer = new Xls($spreadsheet);
        $path = TMP_FOLDER . "/$file_name.xls";
        $writer->save($path);
        return $path;
    }

}
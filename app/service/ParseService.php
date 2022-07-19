<?php
namespace TPPA\APP\service;

use DateTime;

class ParseService {
    function convertNaturezaDespesa($value) {
        $value = strtolower($value);
        if($value == '30' || (strpos($value, 'material') && strpos($value, 'consumo')) || strpos($value, 'consumo') || $value == '339030') {
            $value = '33.90.30';
        }
        if($value == '39' || strpos($value, 'serviços') || strpos($value, 'servicos') || $value == '339039') {
            $value = '33.90.39';
        }
        if($value == '52' || (strpos($value, 'material') && strpos($value, 'permanente')) || strpos($value, 'permanente') || $value == '449052') {
            $value = '44.90.52';
        }
        if($value == '40' || $value == '449040') {
            $value = '44.90.40';
        }
        if($value == '339040') {
            $value = '33.90.40';
        }
        return $value;
    }
} 
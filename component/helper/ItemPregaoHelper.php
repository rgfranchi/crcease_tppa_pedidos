<?php

class ItemPregaoHelper {
    function convertField($name, $value){
        switch($name) {
            case 'valor_unitario' :
            case 'valor_solicitado' :
                $value = convertToMoneyBR($value);
                break;
        }
        return $value;
    }
} 
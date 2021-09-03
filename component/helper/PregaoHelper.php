<?php

class PregaoHelper {
    function convertField($name, $value){
        switch($name) {
            case 'valor_solicitado' :
            case 'valor_total' :
                $value = convertToMoneyBR($value);
                break;
        }
        return $value;
    }
}    
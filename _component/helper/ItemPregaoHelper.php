<?php

class ItemPregaoHelper {
    /**
     * Conversor para Itens do Pregão.
     * @param $name Nome do campo
     * @param $value valor do campo.
     */
    function convert($name, $value){
        switch($name) {
            case 'valor_unitario' :
            case 'valor_solicitado' :
                $value = convertToMoneyBR($value);
                break;
        }
        return $value;
    }
} 
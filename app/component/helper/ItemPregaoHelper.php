<?php
namespace TPPA\APP\component\helper;

use TPPA\CORE\BasicFunctions;

class ItemPregaoHelper {
    /**
     * Conversor para Itens do Pregão.
     * @param $name Nome do campo
     * @param $value valor do campo.
     */
    function convert($name, $value){
        $basicFunctions = new BasicFunctions();
        switch($name) {
            case 'valor_unitario' :
            case 'valor_solicitado' :
                $value = $basicFunctions->convertToMoneyBR($value);
                break;
        }
        return $value;
    }
} 
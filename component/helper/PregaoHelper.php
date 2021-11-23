<?php

class PregaoHelper {
    function convert($name, $value, &$newObject){

        switch($name) {
            // case 'valor_solicitado' :
            // case 'valor_total' :
            //     $value = convertToMoneyBR($value);
            //     break;
            case 'data_limite_solicitacao' :
                $dateNow = new DateTime();
                $dateVencimento = new DateTime($value); 
                $diff = $dateNow->diff($dateVencimento);
                $newObject->data_vencimento_color = "green";
                if($diff->invert == 1) {
                    $newObject->data_vencimento_color = "red";
                } else {
                    if($diff->m < 3) {
                        $newObject->data_vencimento_color = "#DAA520";
                    }
                }
                break;                
        }
        return $value;
    }
}    
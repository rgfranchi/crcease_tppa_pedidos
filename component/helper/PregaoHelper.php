<?php

class PregaoHelper {
    function convertField($name, $value){
        switch($name) {
            case 'valor_solicitado' :
            case 'valor_total' :
                $value = convertToMoneyBR($value);
                break;
            case 'data_vencimento' :
                $dateNow = new DateTime();
                $dateVencimento = new DateTime($value); 
                $diff = $dateNow->diff($dateVencimento);
                $this->data_vencimento_color = "green";
                if($diff->invert == 1) {
                    $this->data_vencimento_color = "red";
                } else {
                    if($diff->m < 3) {
                        $this->data_vencimento_color = "#DAA520";
                    }
                }
                break;                
        }
        return $value;
    }
}    
<?php

include_once('BasicComponent.php');

class PregaoListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_vencimento;
    public $data_vencimento_color;
    public $valor_solicitado;
    public $ativo;

    function convertField($name, $value){
        switch($name) {
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
                $value = convertToDateTimeBR($value, false);
                break;
        }
        $pregaoHelper = new PregaoHelper();
        return $pregaoHelper->convertField($name, $value);
    }
}

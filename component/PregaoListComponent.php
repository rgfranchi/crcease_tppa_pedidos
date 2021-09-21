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
        $pregaoHelper = new PregaoHelper();
        $value = $pregaoHelper->convertField($name, $value);
        switch($name) {
            case 'data_vencimento' :
                $value = convertToDateTimeBR($value, false);
                break;                
        }

        return $value;
    }
}

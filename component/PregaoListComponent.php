<?php

include_once('BasicComponent.php');

class PregaoListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_vencimento_color;
    public $data_vencimento;
    public $valor_solicitado;
    public $ativo;

    function convertField($name, $value, &$newObject = null){
        $pregaoHelper = new PregaoHelper();
        $value = $pregaoHelper->convert($name, $value, $newObject);
        switch($name) {
            case 'data_vencimento' :
                $value = convertToDateTimeBR($value, false);
                break;                
        }
        parent::convertField($name, $value, $newObject);
    }
}
 
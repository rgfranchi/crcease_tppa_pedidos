<?php

include_once('helper/PregaoHelper.php');
include_once('BasicComponent.php');

class PedidoPregaoListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_vencimento;
    public $hashCredito;

    function convertField($name, $value, &$newObject){
        switch($name) {
            case 'data_vencimento' :
                $value = convertToDateTimeBR($value, false);
                break;   
        }
        parent::convertField($name, $value, $newObject);
    }
}
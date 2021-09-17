<?php

include_once('BasicComponent.php');
include_once('helper/PregaoHelper.php');

class PregaoHeadComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $valor_total;
    public $qtd_total;    
    public $qtd_disponivel;    
    public $valor_solicitado;

    function convertField($name, $value){
        $pregaoHelper = new PregaoHelper();
        return $pregaoHelper->convertField($name, $value);
    }
}
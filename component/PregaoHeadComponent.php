<?php

include_once('BasicComponent.php');
include_once('helper/PregaoHelper.php');

class PregaoHeadComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $valor_total;
    public $valor_solicitado;
    public $qtd_total;
    public $qtd_disponivel;

    function convertField($name, $value){
        $pregaoHelper = new PregaoHelper();
        return $pregaoHelper->convertField($name, $value);
    }
}
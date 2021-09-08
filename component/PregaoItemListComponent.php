<?php

include_once 'helper/PregaoItemHelper.php';

class PregaoItemListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $nome;
    public $descricao;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value){
        $pregaoItemHelper = new PregaoItemHelper();
        return $pregaoItemHelper->convertField($name, $value);
    }

}
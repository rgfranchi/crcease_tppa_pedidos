<?php

include_once('helper/ItemPregaoHelper.php');

class ItemPregaoListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $nome;
    public $descricao;
    public $fornecedor;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value){
        $helper = new ItemPregaoHelper();
        return $helper->convertField($name, $value);
    }

}
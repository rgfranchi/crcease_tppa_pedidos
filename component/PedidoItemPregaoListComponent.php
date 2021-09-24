<?php

include_once('BasicComponent.php');
include_once('helper/ItemPregaoHelper.php');

class PedidoItemPregaoListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $nome;
    public $descricao;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value){
        $helper = new ItemPregaoHelper();

        switch($name) {
            case 'data_vencimento' :
                $value = convertToDateTimeBR($value, false);
                break;                
        }
        return $helper->convertField($name, $value);
    }

}
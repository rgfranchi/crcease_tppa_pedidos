<?php

include_once('BasicComponent.php');
include_once('helper/PregaoItemHelper.php');

class PedidoPregaoItemListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $nome;
    public $descricao;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value){
        $pregaoItemHelper = new PregaoItemHelper();

        switch($name) {
            case 'data_vencimento' :
                $value = convertToDateTimeBR($value, false);
                break;                
        }

        
        return $pregaoItemHelper->convertField($name, $value);
    }

}
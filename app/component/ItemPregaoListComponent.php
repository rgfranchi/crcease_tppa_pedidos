<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\CORE\component\BasicComponent;

// include_once('helper/ItemPregaoHelper.php');

class ItemPregaoListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $descricao;
    public $fornecedor;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value, &$newObject){
        $helper = new ItemPregaoHelper();
        parent::convertField($name, $helper->convert($name, $value), $newObject);
    }

}
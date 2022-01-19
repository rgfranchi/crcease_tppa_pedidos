<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

// include_once('BasicComponent.php');
// include_once('helper/ItemPregaoHelper.php');

class PedidoItemPregaoListComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao;
    public $fornecedor;
    public $descricao;
    public $valor_unitario;
    public $qtd_disponivel;

    function convertField($name, $value, &$newObject){
        $helper = new ItemPregaoHelper();
        $basicFunctions = new BasicFunctions();
        switch($name) {
            case 'data_vencimento' :
                $value = $basicFunctions->convertToDateTimeBR($value, false);
                break;                
        }
        $value = $helper->convert($name, $value, $newObject);

        parent::convertField($name, $value, $newObject);

    }

}
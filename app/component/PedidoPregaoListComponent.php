<?php

namespace TPPA\APP\component;

use TPPA\APP\component\helper\PregaoHelper;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

// include_once('helper/PregaoHelper.php');
// include_once('BasicComponent.php');

class PedidoPregaoListComponent extends BasicComponent
{
    public $_id;
    public $pregao_id;
    public $setor;
    public $solicitante;
    public $aprovador;
    public $status;

    public $hashCredito;

    /**
     * Array <br>
     * key -> pregao_item_id<br>
     * value -> quantidade
     */
    public $itens_pedido;

    /**
     * Data hora que foi criado o registro.
     */
    public $create;
    /**
     * Data hora que foi atualizado o registro.
     */
    public $update;

    function convertField($name, $value, &$newObject){
        $basicFunctions = new BasicFunctions();
        switch($name) {
            case 'create' :
                $value = $basicFunctions->convertToDateTimeBR(date('Y-m-d H:i:s',$value), false);
                break;   


        }
        parent::convertField($name, $value, $newObject);
    }
}
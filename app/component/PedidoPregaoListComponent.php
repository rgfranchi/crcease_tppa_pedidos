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
    public $nome;
    public $objeto;
    public $data_limite_solicitacao;
    public $hashCredito;

    function convertField($name, $value, &$newObject){
        $helper = new PregaoHelper();
        $basicFunctions = new BasicFunctions();
        $helper->convert($name, $value, $newObject);        
        switch($name) {
            case 'data_limite_solicitacao' :
                $value = $basicFunctions->convertToDateTimeBR($value, false);
                break;   
        }

        parent::convertField($name, $value, $newObject);
    }
}
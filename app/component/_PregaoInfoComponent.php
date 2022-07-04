<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\PregaoHelper;
use TPPA\CORE\component\BasicComponent;

// include_once('BasicComponent.php');
// include_once('helper/PregaoHelper.php');

class PregaoInfoComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $termo_referencia_origem;
    public $valor_total;
    public $valor_solicitado;
    public $numero_processo_PAG;
    public $url_proposta;
    public $url_anexo;
    public $url_siasg_net;

    function convertFieldRead($name, $value, &$newObject){
        $pregaoHelper = new PregaoHelper();
        $value = $pregaoHelper->convert($name, $value, $newObject);
        parent::convertFieldRead($name, $value, $newObject);
    }
}

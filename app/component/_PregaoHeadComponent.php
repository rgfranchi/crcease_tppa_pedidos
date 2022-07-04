<?php
namespace TPPA\APP\component;

use TPPA\CORE\component\BasicComponent;
use TPPA\APP\component\helper\PregaoHelper;
use TPPA\CORE\BasicFunctions;

// include_once('BasicComponent.php');
// include_once('helper/PregaoHelper.php');

class PregaoHeadComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_homologacao;
    public $data_limite_solicitacao;
    public $url_proposta;
    public $url_anexo;
    public $url_siasg_net;    
    // public $valor_total;
    // public $qtd_total;    
    // public $qtd_disponivel;    
    // public $valor_solicitado;

    function convertFieldRead($name, $value, &$newObject){
        $pregaoHelper = new PregaoHelper();
        $basicFunctions = new BasicFunctions();
        $value = $pregaoHelper->convert($name, $value, $newObject);
        switch($name) {
            case 'data_limite_solicitacao' :
                $value = $basicFunctions->convertToDateTimeBR($value, false);
                break;                
            case 'data_homologacao' :
                $value = $basicFunctions->convertToDateTimeBR($value, false);
                break;                
        }        
        parent::convertFieldRead($name, $value, $newObject);
    }
}
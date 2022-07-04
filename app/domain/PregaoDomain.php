<?php
namespace TPPA\APP\domain;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\domain\BasicDomain;

use function TPPA\CORE\basic\pr;

// include_once('BasicDomain.php');

class PregaoDomain extends BasicDomain
{
    public $_id;
    public $nome;
    public $objeto;
    public $termo_referencia_origem;
    public $data_homologacao;
    public $data_limite_solicitacao;
    public $numero_processo_PAG;
    public $url_proposta;
    public $url_anexo;
    public $url_siasg_net;
    public $ativo;

    // /**  
    //  * @param PregoesItens 
    //  */
    // public $pregoes_itens = array(); 

    // function convertFieldRead($name, $value, &$newObject){
    //     $basicFunctions = new BasicFunctions();
    //     switch($name) {
    //         case 'data_homologacao' :
    //             $value = $basicFunctions->convertToDateTimeBR($value, false);
    //             break;
    //         case 'data_limite_solicitacao' :
    //             $value = $basicFunctions->convertToDateTimeBR($value, false);
    //             break;
    //     }
    //     parent::convertFieldRead($name, $value, $newObject);
    // }
    function afterRead($data){
        $basicFunctions = new BasicFunctions();
        $data['data_homologacao'] = $basicFunctions->convertToDateTimeBR($data['data_homologacao'], false);
        $data['data_limite_solicitacao'] = $basicFunctions->convertToDateTimeBR($data['data_limite_solicitacao'], false);
        return parent::afterRead($data);
    }

    function beforeSave($data)
    {
        $basicFunctions = new BasicFunctions();
        $data['data_homologacao'] = $basicFunctions->convertToDateTimeSystem($data['data_homologacao'], false);
        $data['data_limite_solicitacao'] = $basicFunctions->convertToDateTimeSystem($data['data_limite_solicitacao'], false);
        return parent::beforeSave($data);
    }

    function beforeDelete($deleteId)
    {
        return parent::beforeDelete($deleteId);
    }
}

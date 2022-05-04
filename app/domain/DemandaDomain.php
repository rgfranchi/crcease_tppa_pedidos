<?php
namespace TPPA\APP\domain;

use TPPA\APP\component\helper\ParseFunctions;
use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

// include_once('BasicDomain.php');

class DemandaDomain extends BasicDomain implements iBasicDomain {
    public $_id;
    public $nome;
    public $descricao;
    public $natureza_despesa;
    public $natureza; // Projeto ou Atividade.
    public $observacao;
    public $ativo;

    function convertField($name, $value, &$newObject){
        $parseFunctions = new ParseFunctions();
        switch($name) {
            case 'natureza_despesa' :
                $value = $parseFunctions->convertNaturezaDespesa($value);
                break;
        }
        parent::convertField($name, $value, $newObject);
    }
    
}
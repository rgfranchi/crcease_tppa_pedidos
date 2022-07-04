<?php
namespace TPPA\APP\domain;

use TPPA\APP\component\helper\ParseFunctions;
use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

use function TPPA\CORE\basic\pr;

// include_once('BasicDomain.php');

class DemandaDomain extends BasicDomain {
    public $_id;
    public $nome;
    public $descricao;
    public $natureza_despesa;
    public $natureza; // Projeto ou Atividade.
    public $observacao;
    public $filtro_repositorio;    
    public $filtro_natureza_despesa;
    // Arrai com valores de busca.
    public $ativo;

    // function convertFieldSave($name, $value, &$newObject){
    //     $parseFunctions = new ParseFunctions();
    //     switch($name) {
    //         case 'natureza_despesa' :
    //             $value = $parseFunctions->convertNaturezaDespesa($value);
    //             break;
    //         case 'filtro_repositorio' :
    //             $value = explode(";",$value);
    //             foreach($value as $key => &$val) {
    //                 $val = trim($val);
    //                 if(empty($val)) { 
    //                     unset($value[$key]); 
    //                 }
    //             }
    //             break;
    //     }
    //     parent::convertFieldSave($name, $value, $newObject);
    // }

    function convertFieldRead($name, $value, &$newObject){
        $parseFunctions = new ParseFunctions();
        switch($name) {
            case 'filtro_repositorio' :
                $value = implode(";",$value);
                break;
            case 'natureza_despesa' :
                $value = $parseFunctions->convertNaturezaDespesa($value);
                break;                
        }
        parent::convertFieldRead($name, $value, $newObject);
    }


    function beforeSave($data)
    {
        $parseFunctions = new ParseFunctions();
        $data['filtro_natureza_despesa'] = isset($data['filtro_natureza_despesa']) ? 1 : 0;
        $data['natureza_despesa'] = $parseFunctions->convertNaturezaDespesa($data['natureza_despesa']);
        $arrFiltroRepositorio = explode(";",$data['filtro_repositorio']);
        foreach($arrFiltroRepositorio as $key => &$val) {
            $val = trim($val);
            if(empty($val)) { 
                unset($arrFiltroRepositorio[$key]); 
            }
        }
        $data['filtro_repositorio'] = $arrFiltroRepositorio;
        return parent::beforeSave($data);
    }
    
}
<?php
namespace TPPA\APP\domain;

use TPPA\APP\service\ParseService;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\domain\BasicDomain;

use function TPPA\CORE\basic\pr;

// include_once('BasicDomain.php');

class ItemPregaoDomain extends BasicDomain
{
    public $_id;
    public $cod_item_pregao; // código do item no PE.
    public $descricao;
    public $valor_unitario;
    public $qtd_total;
    public $unidade; // unidade de medida.
    public $fornecedor; // fornecedor do item
    // public $qtd_minima; 
    /**
     * 33.90.30 - Material de Consumo
     * 33.90.39 - Outros Serviços de Terceiros - Pessoa Jurídica
     * 44.90.52 - Equipamentos e Material Permanente – incorporando ao patrimônio
     * 44.90.40 - Serviços de Tecnologia da Informação e Comunicação – Pessoa Jurídica"
     * 33.90.40 - Comunicação de Dados
    */
    public $natureza_despesa;  

    public $observacao;

    // id do Objeto Pregoes.php
    public $pregao_id;


    function afterRead($data)
    {
        $basicFunction = new BasicFunctions();
        $parseService = new ParseService();
        $data['valor_unitario'] = $basicFunction->convertToMoneyBR($data['valor_unitario']);
        $data['natureza_despesa'] = $parseService->convertNaturezaDespesa($data['natureza_despesa']);
        return parent::afterRead($data);
    }

    // function convertFieldRead($name, $value, &$newObject){
    //     $basicFunction = new BasicFunctions();
    //     $parseFunctions = new ParseFunctions();



    //     switch($name) {
    //         case 'valor_unitario' :
    //             if(is_null($value)) break;
    //         case 'valor_solicitado' :
    //             $value = $value = $basicFunction->convertToMoneyBR($value);
    //             break;
    //         case 'natureza_despesa' :
    //             $value = $parseFunctions->convertNaturezaDespesa($value);
    //             break;
    //     }
    //     parent::convertFieldRead($name, $value, $newObject);
    // }

    function validateSave($data)
    {
        $basicFunction = new BasicFunctions();
        $fieldValidade = ['valor_unitario', 'cod_item_pregao', 'descricao'];
        foreach ($fieldValidade as $value) {
            if(!isset($data[$value]) || is_null($data[$value])){
                $basicFunction->loadException("Campo '$value' com valor '". $data[$value]."' inválido");
                return false;
            }  
        }
        return true;
    }

    function beforeSave($data)
    {
        $basicFunction = new BasicFunctions();
        $parseFunctions = new ParseService();
        $data['valor_unitario'] = $basicFunction->convertCommaToDot($data['valor_unitario']);
        $data['natureza_despesa'] = $parseFunctions->convertNaturezaDespesa(@$data['natureza_despesa']);
        return parent::beforeSave($data);
    }
}

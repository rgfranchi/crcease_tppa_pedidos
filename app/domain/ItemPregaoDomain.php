<?php
namespace TPPA\APP\domain;

use TPPA\APP\component\helper\ParseFunctions;
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
        $parseFunctions = new ParseFunctions();
        $data['valor_unitario'] = $basicFunction->convertToMoneyBR($data['valor_unitario']);
        $data['natureza_despesa'] = $parseFunctions->convertNaturezaDespesa($data['natureza_despesa']);
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

    function validateField($name, $value)
    {
        $basicFunction = new BasicFunctions();
        $validate = true;
        switch($name) {
            case 'valor_unitario' :
                if($validate = !is_null($value)) 
                break;
            case 'cod_item_pregao' :
            case 'descricao' :
                $validate = !is_null($value);
                break;
        }
        if(!$validate) {
            $basicFunction->loadException("Campo '$name' com valor '$value' inválido");
        } 
    }

    function beforeSave($data)
    {
        $basicFunction = new BasicFunctions();
        $parseFunctions = new ParseFunctions();
        $data['valor_unitario'] = $basicFunction->convertCommaToDot($data['valor_unitario']);
        $data['natureza_despesa'] = $parseFunctions->convertNaturezaDespesa($data['natureza_despesa']);
        return parent::beforeSave($data);
    }
}

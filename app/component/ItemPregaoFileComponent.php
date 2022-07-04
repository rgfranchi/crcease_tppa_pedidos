<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\APP\domain\ItemPregaoDomain;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once('helper/ItemPregaoHelper.php');

/**
 * Realiza calculo com os itens do pregão.

 */
class ItemPregaoFileComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao; // código do item no PE.
    public $descricao;
    public $valor_unitario;
    public $qtd_total;
    // public $qtd_disponivel; // qtd disponível para solicitação
    // public $qtd_solicitada; // quantidade solicitada do PE
    public $unidade; // unidade de medida.
    public $fornecedor; // fornecedor do item
    public $qtd_minima; 
    /**
     * 33.90.30 - Material de Consumo
     * 33.90.39 - Outros Serviços de Terceiros - Pessoa Jurídica
     * 44.90.52 - Equipamentos e Material Permanente – incorporando ao patrimônio
     * 44.90.40 - Serviços de Tecnologia da Informação e Comunicação – Pessoa Jurídica"
     * 33.90.40 - Comunicação de Dados
    */
    public $natureza_despesa;  

    // id do Objeto Pregoes.php
    public $pregao_id;

    // apenas no arquivo.
    public $cnpj;


    // function arrayOptionFields() {

    //     $basicFunctions = new BasicFunctions();
    //     $newComponent = array();
    //     foreach(array_keys($this->getObjectArray()) as $keys) {
    //         switch($keys) {
    //             case "_id":
    //                 $newComponent[$keys] = "_ID DO SISTEMA";
    //             case "pregao_id":
    //                 continue;
    //             case 'qtd_total':
    //             case 'cod_item_pregao' :
    //             case 'descricao' : 
    //             case 'valor_unitario' :
    //                 $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys)." *";
    //                 break;          
    //             default:
    //             $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys);
    //         }
    //     }
    //     return $newComponent;
    // }


    function convertToData($data, $post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $load = $post['data_load'];
        $tmpData = array();
        foreach($load as $itens) {
            // cria objeto para inserção ou adiciona valores para update.
            $newObject = new ItemPregaoDomain();
            $pos_id = array_search('_id', $typeField);
            if($pos_id !== false) {
                if(is_numeric($itens[$pos_id])) {
                    $newObject = (object) $data->findById($itens[$pos_id]);    
                } else {
                    continue;
                }
            } 

            $pos_qtd_total = array_search('qtd_total', $typeField);
            if(!is_numeric($itens[$pos_qtd_total])) {
                continue;  
            } 
            if($itens[$pos_qtd_total] < 0) {
                continue;
            }


            $newObject->pregao_id = $pregao_id;
            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);

                switch($type) {
                    case 'null':
                        continue;
                        break;
                    case 'cnpj': // agrupa fornecedor com CNPJ.
                        $newObject->fornecedor = empty($newObject->fornecedor) ? $value : $newObject->fornecedor." - ".$value;
                        break;
                }
                if(property_exists($newObject, $type)) {
                    $newObject->{$type} = $value;
                }
            }
            $tmpData[] = (array) $newObject;
        }
        if(!empty($tmpData)) {
            return $tmpData;
        }
        return false;
    }

}
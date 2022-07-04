<?php
namespace TPPA\APP\mapper;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\mapper\BasicMapper;
// include_once 'BasicMapper.php';

class ItemPregaoMapItemPregaoFileMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> domínio do objeto 
     */
    function __construct()
    {
        parent::__construct("ItemPregao", "ItemPregaoFile", "ItemPregao");
    }

    function arrayOptionFields() {

        $basicFunctions = new BasicFunctions();

        // View converte camel case to TextCase
        $component = (array) $this->getComponent();

        $newComponent = array();
        foreach(array_keys($component) as $keys) {
            
            switch($keys) {
                case "_id":
                    $newComponent[$keys] = "_ID DO SISTEMA";
                case "pregao_id":
                    continue;
                case 'qtd_total':
                case 'cod_item_pregao' :
                case 'descricao' : 
                case 'valor_unitario' :
                    $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys)." *";
                    break;          
                default:
                $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys);
            }
        }
        return $newComponent;
    }

    function saveAllItemPregao($post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $data = $post['data_load'];
        $tmpData = array();
        foreach($data as $itens) {
            // cria objeto para inserção ou adiciona valores para update.
            $newObject = new $this->domain;
            $pos = array_search('_id', $typeField);
            if($pos !== false) {
                $newObject = $this->item_pregao->findById($itens[$pos]);
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
                    case 'fornecedor': // já possui valor, provável CNPJ.
                        $newObject->fornecedor = empty($newObject->fornecedor) ? $value : $value." - ".$itens['cnpj'];
                        break;
                }
                $this->domain->convertField($type,$value, $newObject);
                $this->domain->validateField($type, $value);
            }
            $tmpData[] = (array) $newObject;
        }
        if(!empty($tmpData)) {
            $this->domain()->saveAll($tmpData);
        }
        return true;
    }

}

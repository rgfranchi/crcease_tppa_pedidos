<?php

include_once 'BasicMapper.php';

class ItemPregaoMapItemPregaoFileMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("ItemPregao", "ItemPregaoFile", "ItemPregao");
    }

    function arrayOptionFields() {
        // View converte camel case to TextCase
        $component = (array) $this->getComponent();

        $newComponent = array();
        foreach(array_keys($component) as $keys) {
            
            switch($keys) {
                case "_id":
                    $newComponent[$keys] = "_ID DO SISTEMA";
                case "pregao_id":
                    continue;
                case 'qtd_disponivel' :                    
                case 'qtd_total':
                    $newComponent[$keys] = snakeToTextCase($keys)." **";
                    break;
                case 'cod_item_pregao' :
                case 'nome' : 
                case 'valor_unitario' :
                    $newComponent[$keys] = snakeToTextCase($keys)." *";
                    break;          
                default:
                $newComponent[$keys] = snakeToTextCase($keys);
            }
        }
        return $newComponent;
    }

    function saveAllItemPregao($post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $data = $post['data_load'];
        foreach($data as $itens) {
            // cria objeto para inserção ou adiciona valores para update.
            $pos = array_search('_id', $typeField);
            if($pos !== false) {
                $tmpItem = (array) $this->item_pregao->findById($itens[$pos]);
                $itemPregao = empty($tmpItem) ? (array) $this->domain : $tmpItem;
            } else {
                $itemPregao = (array) $this->domain;
            }
            $itemPregao['pregao_id'] = $pregao_id;
            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);
                switch($type) {
                    case 'null':
                        continue;
                        break;
                    case 'cnpj': // agrupa fornecedor com CNPJ.
                        $itemPregao['fornecedor'] = empty($itemPregao['fornecedor']) ? $value : $itemPregao['fornecedor'] .= " - ".$value;
                        break;
                    case 'fornecedor': // já possui valor, provável CNPJ.
                        $itemPregao['fornecedor'] = empty($itemPregao['fornecedor']) ? $value : $value .= " - ".$itemPregao['fornecedor'];
                        break;
                    default:
                        $itemPregao[$type] = $value;
                }
            }
            $this->domain()->save($itemPregao);
        }
        return true;
    }

}

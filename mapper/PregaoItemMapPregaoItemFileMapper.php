<?php

include_once 'BasicMapper.php';

class PregaoItemMapPregaoItemFileMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("PregaoItem", "PregaoItemFile", "PregaoItem");
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

    function saveAllPregaoItem($post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $data = $post['data_load'];
        foreach($data as $itens) {
            // cria objeto para inserção ou adiciona valores para update.
            $pos = array_search('_id', $typeField);
            if($pos !== false) {
                $tmpItem = (array) $this->pregao_item->findById($itens[$pos]);
                $pregaoItem = empty($tmpItem) ? (array) $this->domain : $tmpItem;
            } else {
                $pregaoItem = (array) $this->domain;
            }
            $pregaoItem['pregao_id'] = $pregao_id;
            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);
                switch($type) {
                    case 'null':
                        continue;
                        break;
                    case 'cnpj': // agrupa fornecedor com CNPJ.
                        $pregaoItem['fornecedor'] = empty($pregaoItem['fornecedor']) ? $value : $pregaoItem['fornecedor'] .= " - ".$value;
                        break;
                    case 'fornecedor': // já possui valor, provável CNPJ.
                        $pregaoItem['fornecedor'] = empty($pregaoItem['fornecedor']) ? $value : $value .= " - ".$pregaoItem['fornecedor'];
                        break;
                    default:
                        $pregaoItem[$type] = $value;
                }
            }
            $this->domain()->save($pregaoItem);
        }
        return true;
    }

}

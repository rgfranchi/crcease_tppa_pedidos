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
                    $newComponent[$keys] = "ID DO SISTEMA";
                case "pregao_id":
                    continue;
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

        // pr($pregao_id);
        // pr($typeField);
        // pr($data);
        
        foreach($data as $itens) {
            $pregaoItem = (array) $this->domain;
            $pregaoItem['pregao_id'] = $pregao_id;

            // pr($pregaoItem);
            // pr($typeField);
            // die;
            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);
                switch($type) {
                    case 'null':
                        continue;
                        break;
                    // case 'valor_unitario':  
                    // case 'valor_solicitado':  
                    //     is_numeric($value) ? $pregaoItem->{$type} = str_replace(',','',$value) : "";
                    //     break;
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

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
        parent::__construct("PregaoItem", "PregaoItemFile");
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

    function dataPregaoItem($post) {
        $pregao_id = $post['pregao_id'];
        $typeField = $post['typeField'];
        $data = $post['data_load'];
        $newData = array();
        foreach($data as $itens) {
            $pregaoItem = new PregaoItemDomain();
            $pregaoItem->pregao_id = $pregao_id;

            foreach($itens as $key => $value) {
                $type = $typeField[$key];
                $value = trim($value);
                switch($type) {
                    case 'null':
                        continue;
                        break;
                    case 'valor_unitario':  
                    case 'valor_solicitado':  
                        is_numeric($value) ? $pregaoItem->{$type} = str_replace(',','',$value) : "";
                        break;
                    default:
                        $pregaoItem->{$type} = $value;
                }
            }
            $newData[] = $pregaoItem;
        }
        return $newData;
    }

}

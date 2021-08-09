<?php

include_once 'BasicMapper.php';

class PregaoItemToPregaoItemFileMapper extends BasicMapper
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
}

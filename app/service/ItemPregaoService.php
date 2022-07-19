<?php

use TPPA\APP\domain\ItemPregaoDomain;
use TPPA\CORE\BasicSystem;

class ItemPregaoService extends BasicSystem {

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

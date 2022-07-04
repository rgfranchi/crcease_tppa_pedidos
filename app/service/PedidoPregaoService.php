<?php
namespace TPPA\APP\service;
use TPPA\CORE\BasicSystem;
use function TPPA\CORE\basic\pr;

class PedidoPregaoService extends BasicSystem 
{
    function inLineTotalAprovados($res) {
        $inLineheader = [];
        foreach ($res['HEADER'] as $key => $value) {
            
            if(is_array($value)) {
                $_key = str_replace("_","",$key);
                $inLineheader[$_key] = $value['setor'] . "-" . $value['solicitante'] . "." . $value['status'] . '('. $_key .')' ;
            } else {
                $inLineheader[$key] = $value;
            }
        }
        
        $newInline = [];
        foreach ($res['BODY'] as $key => $value) {
            $newValue = [];
            foreach($inLineheader as $key_header => $value_header) {
                if(is_numeric($key_header)) {
                    if(isset($value['pedidos'][$key_header])) {
                        $newValue[$value_header] = $value['pedidos'][$key_header]['quantidade'];
                    } else {
                        $newValue[$value_header] = 0;
                    }
                    continue;
                } else {
                    if(isset($value[$key_header])) {
                        $newValue[$value_header] = $value[$key_header];
                    }
                }
            }
            if(isset($value['_id'])) {
                $newInline[] = $newValue;
            }
        }
        return $newInline;
    }

}

?>
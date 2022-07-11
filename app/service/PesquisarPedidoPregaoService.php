<?php
namespace TPPA\APP\service;
use TPPA\CORE\BasicSystem;

class PesquisarPedidoPregaoService extends BasicSystem 
{
    /**
     * Verifica necessidade de ajuste na variável find.
     */
    function findConvert(&$find){
        if(empty($find)) {
            return false;
        } 
        $find = "%".str_replace("/",'%',trim($find))."%";
    }
}
?>
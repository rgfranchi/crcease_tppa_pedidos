<?php

include_once 'BasicMapper.php';

class PregaoItensToPregaoItemListMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("PregaoItens", "PregaoItemList");
    }


    function getAllItens($pregao)
    {
        $ret = null;
        if (is_array($pregao)) {

            foreach ($pregao as $key => $value) {
                $ret[$key] = $value->pregao_itens;
            }
        } else {
            $ret = array($pregao);
        }
        $this->component = $ret;
    }
}

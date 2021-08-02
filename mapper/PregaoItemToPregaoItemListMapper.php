<?php

include_once 'BasicMapper.php';

class PregaoItemToPregaoItemListMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> domínio do objeto 
     */
    function __construct()
    {
        parent::__construct("PregaoItem", "PregaoItemList");
    }
}

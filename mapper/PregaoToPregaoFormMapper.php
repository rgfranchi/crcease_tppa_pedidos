<?php 

include_once 'BasicMapper.php';

class PregaoToPregaoFormMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("Pregao", "PregaoForm");
    }

}

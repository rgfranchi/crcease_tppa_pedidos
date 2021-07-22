<?php 

include 'BasicMapper.php';

class PregaoToPregaoListMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("Pregoes", "PregaoList");
    }

}
?>
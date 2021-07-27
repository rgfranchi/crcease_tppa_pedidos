<?php 

include_once 'BasicMapper.php';

class PregaoToPregaoItensListMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("Pregoes", "PregaoItensList");
    }


    function getAllItens($pregao) {
        $ret = null;
        if(is_array($pregao)) {
            foreach($pregao as $key => $value) {
                $ret[$key] = $value->pregao_itens;
            }
        } else {
            $ret = $pregao->pregao_itens;
        }
        $this->component = $ret;        
    }

}
?>
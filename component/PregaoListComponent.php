<?php

include_once('BasicComponent.php');

class PregaoListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_vencimento_color;
    public $data_limite_solicitacao;
    public $data_homologacao;
    public $ativo;

    function convertField($name, $value, &$newObject = null){
        $pregaoHelper = new PregaoHelper();
        $value = $pregaoHelper->convert($name, $value, $newObject);
        switch($name) {
            case 'data_limite_solicitacao' :
                $value = convertToDateTimeBR($value, false);
                break;                
            case 'data_homologacao' :
                $value = convertToDateTimeBR($value, false);
                break;                
        }
        parent::convertField($name, $value, $newObject);
    }
}
 
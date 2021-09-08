<?php

class PregaoListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $objeto;
    public $data_homologacao;
    public $valor_solicitado;
    public $qtd_disponivel;

    function convertField($name, $value){
        switch($name) {
            case 'data_homologacao' :
                $value = convertToDateTimeBR($value, false);
                break;
        }
        $pregaoHelper = new PregaoHelper();
        return $pregaoHelper->convertField($name, $value);
    }
}

<?php

include_once('BasicComponent.php');
include_once('helper/PregaoHelper.php');

class PregaoFormComponent extends BasicComponent
{

    public $_id;
    public $nome;
    public $objeto;
    public $termo_referencia_origem;
    public $valor_total;
    public $valor_solicitado;
    public $qtd_total;
    public $qtd_disponivel;
    public $data_homologacao;
    public $data_vencimento;
    public $numero_processo_PAG;
    public $url_proposta;
    public $url_anexo;
    public $url_siasg_net;
    public $ativo;

    function convertField($name, $value, &$newObject){
        $pregaoHelper = new PregaoHelper();
        $value = $pregaoHelper->convert($name, $value, $newObject);
        parent::convertField($name, $value, $newObject);
    }
}

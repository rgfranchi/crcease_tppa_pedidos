<?php

include_once('BasicDomain.php');

class PregaoDomain extends BasicDomain
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

    // /**  
    //  * @param PregoesItens 
    //  */
    // public $pregoes_itens = array(); 

    function convertField($name, $value, &$newObject){
        switch($name) {
            case 'valor_solicitado' :
            case 'valor_total' :
                $value = convertCommaToDot($value);
                break;
            case 'data_homologacao' :
                $value = convertToDateTimeSystem($value, false);
                break;
        }
        parent::convertField($name, $value, $newObject);
    }

    function validateField($name, $value)
    {
        $validate = true;
        switch($name) {
            case 'valor_solicitado' :
            case 'valor_total' :
                $validate = is_numeric($value);
                break;
        }
        if(!$validate) {
            loadException("Campo $name com valor $value inválido");
        } 
    }

    // EXEMPLO DE TRATAMENTO ANTES DE EXCLUIR.
    // function beforeDelete($deleteId) {
    //     pr($deleteId . " TESTE");
    //     return "REGISTRO NÃO PODE SER EXCLUÍDO";
    // }

}

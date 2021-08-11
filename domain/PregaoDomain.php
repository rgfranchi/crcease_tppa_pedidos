<?php

include 'BasicDomain.php';

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
    public $numero_processo_PAG;
    public $url_proposta;
    public $url_anexo;
    public $url_siasg_net;

    // /**  
    //  * @param PregoesItens 
    //  */
    // public $pregoes_itens = array(); 
}

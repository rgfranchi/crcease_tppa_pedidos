<?php

// namespace Domain;

class Pregoes
{
    public $_id;
    public $nome;
    public $objeto;
    public $url_proposta;
    public $termo_referência_origem;
    public $valor_total;
    public $valor_solicitado;
    public $qtd_total;
    public $qtd_disponivel;
    /**  
     * @param PregoesItens 
     */
    public $pregoes_itens = array();
}

<?php

include_once('BasicDomain.php');

class PregaoItemDomain extends BasicDomain
{
    public $_id;
    public $cod_item_pregao; // codigo do item no PE.
    public $nome; 
    public $descricao;
    public $valor_unitario;
    public $valor_solicitado;
    public $qtd_total;
    public $qtd_disponivel; // qtd disponível para solicitação
    public $qtd_solicitada; // quantidade solicitada do PE
    public $unidade; // unidade de medida.
    public $fornecedor; // fornecedor do item
    public $qtd_minima; 
    /**
     * 33.90.30 - Material de Consumo
     * 33.90.39 - Outros Serviços de Terceiros - Pessoa Jurídica
     * 44.90.52 - Equipamentos e Material Permanente – incorporando ao patrimônio
     * 44.90.40 - Serviços de Tecnologia da Informação e Comunicação – Pessoa Jurídica"
     * 33.90.40 - Comunicação de Dados
    */
    public $natureza_despesa;  

    // Objeto Pregoes.php
    public $pregao_id;


    function getObject()
    {
        $ret = parent::getObject();
        $ret->valor_unitario = convertToMoneyBR($ret->valor_unitario);
        $ret->valor_solicitado = convertToMoneyBR($ret->valor_solicitado);
        return $ret;
    }

    function getObjectArray()
    {
        $ret = parent::getObjectArray();
        $ret['qtd_total'] = empty($ret['qtd_total']) ? $ret['qtd_disponivel'] + $ret['qtd_solicitada'] : $ret['qtd_total'];
        $ret['valor_unitario'] = convertCommaToDot($ret['valor_unitario']);
        $ret['valor_solicitado'] = convertCommaToDot($ret['valor_solicitado']);
        return $ret;
    }  

}

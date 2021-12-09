<?php

include_once('BasicComponent.php');

class ItemPregaoFileComponent extends BasicComponent
{
    public $_id;
    public $cod_item_pregao; // código do item no PE.
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

    // id do Objeto Pregoes.php
    public $pregao_id;

    // apenas no arquivo.
    public $cnpj;
}
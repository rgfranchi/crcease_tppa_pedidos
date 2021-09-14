<?php

include_once('BasicDomain.php');

class PedidoPregaoDomain extends BasicDomain
{
    public $_id;
    public $pregao_id;
    public $setor;
    public $solicitante;

    /**
     * Array <br>
     * key -> pregao_item_id<br>
     * value -> quantidade
     */
    public $itens_id;
}

<?php

include_once('BasicDomain.php');

class PedidoPregaoDomain extends BasicDomain
{
    public $_id;
    public $pregao_id;
    public $setor;
    public $solicitante;
    public $status;

    /**
     * Array <br>
     * key -> pregao_item_id<br>
     * value -> quantidade
     */
    public $itens_pedido;

    function statusPedido() {
        return ["CRIADO", "AGUARDANDO", "APROVADO", "EXECUTADO"];
    }
}




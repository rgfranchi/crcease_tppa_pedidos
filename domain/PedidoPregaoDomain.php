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

    function statusPedido($etapa = "PEDIDO") {
        $status = [
            "SOLICITADO", // Pedido Criado. 
            "AGUARDANDO APROVAÇÃO", // Verificando disponibilidades de valores.
            "APROVADO", // Gestores da meta
            "CREDITO SOLICITADO", // Registrada a Solicitação de Crédito ("SIGA")
            "CREDITADO", // Crédito Recebido (Nota de Credito)
            "EMPENHO SOLICITADO", // Criada a Solicitação (SREQ SILOMS). 
            "EMPENHADO" // Empenho recebido (Valor é subtraido do ItemPregão)
        ];

        switch($etapa) {
            case "PEDIDO" : 
                $status = array_slice($status,0,3);
                break;
            case "CREDITO" :
                $status = array_slice($status,3);
                break;
        }


        return $status;
    }
}




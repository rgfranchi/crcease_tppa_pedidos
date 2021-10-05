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
     * Campo gerado com valor unico após fechamento do crédito.<br>
     * Agrupa mesmo pedido (data_hora YYYYMMDDhhmmss)
     */
    public $hashCredito;

    /**
     * Array <br>
     * key -> pregao_item_id<br>
     * value -> quantidade
     */
    public $itens_pedido;

    /**
     * @param $etapa -> etapa do sistema de acesso.
     */
    function statusPedido($etapa = "PEDIDO") {
        // mater a chave com valor crescente para controle por comparação. > ou <
        $status = array(
            0 => "SOLICITADO", // Pedido Criado. 
            1 => "AGUARDANDO APROVAÇÃO", // Verificando disponibilidades de valores.
            2 => "APROVADO", // Gestores da meta
            3 => "CREDITO SOLICITADO", // Registrada a Solicitação de Crédito ("SIGA")
            4 => "CREDITADO", // Crédito Recebido (Nota de Credito)
            5 => "EMPENHO SOLICITADO", // Criada a Solicitação (SREQ SILOMS). 
            6 => "EMPENHADO" // Empenho recebido (Valor é subtraido do ItemPregão)
        );

        switch($etapa) {
            case "PEDIDO" : 
                $status = array_slice($status,0,3);
                break;
            case "CREDITO" :
                $status = array_slice( $status, 2);
                break;
        }
        return $status;
    }


    function convertField($name, $value){
        switch($name) {
            case 'itens_pedido' :
                foreach ($value as &$qtd) {
                    if(empty($qtd)) {
                        $qtd = 0;
                    }
                }
        }
        return $value;
    }

}




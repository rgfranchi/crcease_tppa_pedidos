<?php
namespace TPPA\APP\domain;

use DateTime;
use TPPA\CORE\domain\BasicDomain;

use function TPPA\CORE\basic\pr;

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
     * Data hora que foi criado o registro.
     */
    public $create;
    /**
     * Data hora que foi atualizado o registro.
     */
    public $update;

    /**
     * @param $etapa -> etapa do sistema de acesso.
     */
    function statusPedido($etapa = "PEDIDO") {
        // mater a chave com valor crescente para controle por comparação. > ou <
        $status = array(
            0 => "RASCUNHO", // Pedido Criado. 
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


    function convertField($name, $value, &$newObject){
        switch($name) {
            case 'itens_pedido' :
                foreach ($value as &$qtd) {
                    if(empty($qtd)) {
                        $qtd = 0;
                    } else {
                        $qtd = intval($qtd);
                    }
                }
        }
        parent::convertField($name, $value, $newObject);
    }

    function beforeSave($data)
    {
        $datetime = new DateTime();
        if(!isset($data['_id'])) {
            $data['create'] = $datetime->getTimestamp();
        }
        $data['update'] = $datetime->getTimestamp();
        return $data;
    }

}




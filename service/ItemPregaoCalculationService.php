<?php
require_once(__ROOT__ . '/config.php');

/**
 * Atualiza valores (qtd_disponivel, qtd_solicitada, valor_solicitado) dos Itens do pregão.
 * Status [CRIADO, AGUARDANDO, APROVADO, EXECUTADO]
 * Altera o item quando o status do pedido estiver como executado.
 */
class ItemPregaoCalculationService extends BasicSystem {
    
    private $invalidItem = array();

    function __construct()
    {
        $this->loadBasicStores('ItemPregao');
    }

    /**
     * Calcula quantidade de itens disponíveis<br>
     * Se o valor do item cadastrado for menor que zero, retorna zero.<br>
     * Preenche variável de controle 
     * @param $pregao_itens itens do objeto pregão
     * @param $pedidos itens pedidos do pregão.
     */
    function disponiveis($pregao_itens, $pedidos) {
        $total_itens_pedido = array();
        foreach($pedidos as $pedido) {
            if($pedido->status === "EMPENHADO" || $pedido->status === "EXCLUIDO") {
                continue;
            }
            if(empty($pedido->itens_pedido)) {
                continue;
            }
            foreach($pedido->itens_pedido as $key => $values) {
                $values = empty($values) ? 0 : $values;
                if(isset($total_itens_pedido[$key])) {
                    $total_itens_pedido[$key] += $values;
                } else {
                    $total_itens_pedido[$key] = $values;
                }
            }
        }
        // se não tiver valores para subtrair.
        if(empty($total_itens_pedido)) {
            return $pregao_itens;
        }
        //nova variável para processar o array mas não modificar.
        $ret = array();
        foreach($pregao_itens as $key => $object) {
            $values = clone($object);
            if(isset($total_itens_pedido[$values->_id])) {
                $values->qtd_disponivel -= $total_itens_pedido[$values->_id];
                if($values->qtd_disponivel < 0) {
                    $this->invalidItem[$values->_id] = $values;
                    // $values->qtd_disponivel = 0;
                }
            }
            $ret[$key] = $values;
        }
        return $ret;
    }

    function getInvalidItem() {
        return $this->invalidItem;
    }


    /**
     * Soma a quantidades de itens por pedido.
     * @param $itens_pregao itens do objeto pregão
     * @param $pedidos itens pedidos do pregão.
     */
    function total_aprovados($pedido_pregao, $pregao_id) {
        $res = array(
            // nome das colunas iniciais.
            'HEADER' => array(
                'cod_item_pregao' => "COD",
                'descricao' => "DESCRIÇÃO",
                'valor_unitario' => "VALOR UNITARIO",
                'fornecedor' => "FORNECEDOR",
            ),
            'BODY' => array()
        );
        $itens_in = array();
        foreach($pedido_pregao as $value) {
            $currKeys = empty($value->itens_pedido) ? array() : array_keys($value->itens_pedido);
            $itens_in = array_unique(array_merge($itens_in, $currKeys));
        }
        // recuperar todos os itens do pregão. 
        $find_itens_pregao = $this->item_pregao->findBy(
            [
                ["pregao_id", "==", $pregao_id], 
                'AND',
                ["_id", "IN", $itens_in]
            ],
            ["cod_item_pregao" => "ASC"]
        );        
        // altera chave do array para id e inclui valores conforme HEADER
        foreach($find_itens_pregao as $value) {
            foreach(array_keys($res['HEADER']) as $param) {
                $res["BODY"][$value->_id][$param] = $value->{$param};
            }
        }
        $res['VALOR_TOTAL'] = 0;
        // Lê cada pedidos, e inclui no corpo o valor.
        foreach($pedido_pregao as $pedidos) {
            $pedido_key = 'pedido_' . $pedidos->_id;
            // nome das colunas pedido
            $res['HEADER'][$pedido_key] = '<small>' . $pedidos->setor . '</small></br><small style="font-size: xx-small;">' . $pedidos->solicitante . '</small>';
            // preenche os itens do pedido.
            foreach($pedidos->itens_pedido as $key_item => $qtd_item) {
                if(isset($res["BODY"][$key_item]['total'])) {
                    $res["BODY"][$key_item]['total'] += $qtd_item;
                } else {
                    $res["BODY"][$key_item]['total'] = $qtd_item;
                }                 
                $res["BODY"][$key_item]['sub_total'] = $res["BODY"][$key_item]['total'] * $res["BODY"][$key_item]['valor_unitario'];
                $res["BODY"][$key_item][$pedido_key] = $qtd_item;
                $res['VALOR_TOTAL'] += $res["BODY"][$key_item]['sub_total'];
             }
             $res['pedidos_id'][] = $pedidos->_id;   
        }
        foreach($res["BODY"] as $key => $value){
            if($value['total'] == 0) {
                unset($res["BODY"][$key]);
            }
        }
        // nome das colunas TOTAIS.
        $res['HEADER']['sub_total'] = 'SUB TOTAL';
        $res['HEADER']['total'] = "TOTAL";
        return $res;
    }
    
    /**
     * Recebe pedidos e inclui informação dos itens solicitados.<br>
     * Totaliza quantidade e valores por item e total.
     * @param object $pedido realizado 
     */
    function solicitados($pedido) {
        $pedido_valor_total = 0;
        $pedido_quantidade_total = 0;

        $pedido->itens_pedido = array_filter($pedido->itens_pedido);
        $item_pregao_pedido = $this->item_pregao->findBy(["_id", "IN", array_keys($pedido->itens_pedido)],['cod_item_pregao' => 'asc']);

        $tmpItemPedido = array();
        foreach($item_pregao_pedido as $item) {
            if(empty($item)) {
                continue;
            }
            $value = $pedido->itens_pedido[$item->_id];
            $item->pedido_valor = $value * $item->valor_unitario;
            $pedido_valor_total += $item->pedido_valor;
            $pedido_quantidade_total += $value;
            $item->pedido_quantidade = $value;
            $item->pedido_valor = convertToMoneyBR($item->pedido_valor);
            $item->valor_unitario = convertToMoneyBR($item->valor_unitario);
            $item->valor_solicitado = convertToMoneyBR($item->valor_solicitado);
            $tmpItemPedido[$item->_id] = $item;
        }
        $pedido->itens_pedido = $tmpItemPedido;
        $pedido->pedido_valor_total = convertToMoneyBR($pedido_valor_total);
        $pedido->pedido_quantidade_total =  $pedido_quantidade_total;

        return $pedido;
    }
}
<?php
namespace TPPA\APP\service;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\BasicSystem;


use function TPPA\CORE\basic\pr;

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
        $this->loadBasicStores('PedidoPregao');
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
                'sub_total_valor' => 'SUB TOTAL (R$)',
                'sub_total_quantidade' => 'SUB TOTAL (UN)',
            ),
            'BODY' => array(),
            'total_valor' => 0,
            'total_quantidade' => 0
        );

        // recupera _id dos itens do pedido.
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

        $join = $this->joins_itens_pedidos($pedido_pregao, $find_itens_pregao);
        // retira valores que não será exibido.
        foreach($join as $key => &$pedidos) {
            unset($pedidos->valor_solicitado);
            unset($pedidos->qtd_total);
            unset($pedidos->qtd_disponivel);
            unset($pedidos->qtd_solicitada);
            unset($pedidos->unidade);
            unset($pedidos->qtd_minima);
            unset($pedidos->natureza_despesa);
            unset($pedidos->pregao_id);
            $res['total_valor'] += $pedidos->sub_total_valor;
            $res['total_quantidade'] += $pedidos->sub_total_quantidade;
        }

        $res['BODY'] = $join;
        return $res;
    }
    
    /**
     * Realiza a junção do array dos ItemPregão com PedidoPregao.
     * Acrescenta e calcula colunas sub_total_valor e sub_total_quantidade
     * 
     * @param $pedido_pregao array com objetos PedidoPregao, 
     * @param $item_pregao array com objetos ItemPregão, 
     * @return array com objetos item pregão adicionado dos pedidos.
     */
    function joins_itens_pedidos($pedido_pregao, $item_pregao) {
        $export = null;
        foreach($item_pregao as $item_key => $item) {
            // informações do item.
            $val_unitario = $item->valor_unitario;
            $item->sub_total_valor = 0.0;
            $item->sub_total_quantidade = 0;
            // leitura dos pedidos.
            foreach($pedido_pregao as $pedido) {
                // título com nome do pedido.
                $param = $pedido->setor . '-' . $pedido->solicitante. '(' . $pedido->status . ' [' .$pedido->_id. '])';
                if(isset($pedido->itens_pedido[$item->_id])) {
                    $qtd_solicitada = $pedido->itens_pedido[$item->_id];
                    $tmp_sub_total_valor = $item->sub_total_valor;
                    unset($item->sub_total_valor);
                    $tmp_sub_total_quantidade = $item->sub_total_quantidade;
                    unset($item->sub_total_quantidade);
                    
                    $item->{$param} = $pedido->itens_pedido[$item->_id];
                    $item->sub_total_valor = $tmp_sub_total_valor + ($qtd_solicitada * $val_unitario);
                    $item->sub_total_quantidade = $tmp_sub_total_quantidade + $qtd_solicitada;
                } 
            }
            $export[$item_key] = $item;
        }   
        return $export;     
    }


    /**
     * Recebe pedidos e inclui informação dos itens solicitados.<br>
     * Totaliza quantidade e valores por item e total.
     * @param object $pedido realizado 
     */
    function solicitados($pedido) {
        $basicFunctions = new BasicFunctions();
        $pedido_valor_total = 0;
        $pedido_quantidade_total = 0;

        $pedido->itens_pedido = array_filter($pedido->itens_pedido);

        $item_pregao_pedido = $this->item_pregao->findBy(["_id", "IN", array_keys($pedido->itens_pedido)],['cod_item_pregao' => 'asc']);

        // pr($item_pregao_pedido);
        // pedidos já realizado no pregão.
        $pedido_pregao = $this->pedido_pregao->findBy([["pregao_id","==",$pedido->pregao_id],['status','NOT IN',['RASCUNHO','AGUARDANDO APROVAÇÃO']] ]);

        $total_itens_aprovados = array();
        foreach($pedido_pregao as $value){
            $itens = array_filter($value->itens_pedido);
            array_walk_recursive($itens, function($value, $key) use (&$total_itens_aprovados) {
                if(isset($total_itens_aprovados[$key])) {
                    $total_itens_aprovados[$key] += $value;  
                } else {
                    $total_itens_aprovados[$key] = $value;
                }
            });
        }
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
            $item->pedido_valor = $basicFunctions->convertToMoneyBR($item->pedido_valor);
            $item->valor_unitario = $basicFunctions->convertToMoneyBR($item->valor_unitario);
            $item->valor_solicitado = $basicFunctions->convertToMoneyBR($item->valor_solicitado);

            $item->qtd_solicitada = isset($total_itens_aprovados[$item->_id]) ? $total_itens_aprovados[$item->_id] : 0;

            $tmpItemPedido[$item->_id] = $item;
        }
        $pedido->itens_pedido = $tmpItemPedido;
        $pedido->pedido_valor_total = $basicFunctions->convertToMoneyBR($pedido_valor_total);
        $pedido->pedido_quantidade_total =  $pedido_quantidade_total;
        return $pedido;
    }
}
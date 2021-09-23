<?php

require_once(__ROOT__ . '/config.php');


/**
 * Atualiza valores (qtd_disponivel, qtd_solicitada, valor_solicitado) dos Itens do pregão.
 * Status [CRIADO, AGUARDANDO, APROVADO, EXECUTADO]
 * Altera o item quando o status do pedido estiver como executado.
 */
class PregaoItemCalculationService extends BasicSystem {
    
    private $objectPregao = null;

    function __construct()
    {
        $this->loadBasicStores('PregaoItem');
    }

    /**
     * Calcula quantidade de itens disponíveis 
     * @param $pregao_itens itens do objeto pregão
     * @param $pedidos itens pedidos do pregão.
     */
    function disponiveis($pregao_itens, $pedidos) {
        $total_itens_pedido = array();
        foreach($pedidos as $pedido) {
            foreach($pedido->itens_pedido as $key => $values) {
                $values = empty($values) ? 0 : $values;
                if(isset($total_itens_pedido[$key])) {
                    $total_itens_pedido[$key] += $values;
                } else {
                    $total_itens_pedido[$key] = $values;
                }
            }
        }
        foreach($pregao_itens as &$values) {
            if(isset($total_itens_pedido[$values->_id])) {
                $values->qtd_disponivel -= $total_itens_pedido[$values->_id];
            }
        }

        return $pregao_itens;
    }

    /**
     * Recebe pedidos e inclui informação dos itens solicitados.<br>
     * Totaliza quantidade e valores por item e total.
     * @param object $pedido realizado 
     */
    function solicitados($pedido) {
        $pedido_valor_total = 0;
        $pedido_quantidade_total = 0;
        foreach($pedido->itens_pedido as $key => &$value) {
            $item = $this->pregao_item->findById($key);
            if(empty($item)) {
                continue;
            }

            $item->pedido_valor = $value * $item->valor_unitario;
            $pedido_valor_total += $item->pedido_valor;
            $pedido_quantidade_total += $value;

            $item->pedido_quantidade = $value;
            $item->pedido_valor = convertToMoneyBR($item->pedido_valor);
            $item->valor_unitario = convertToMoneyBR($item->valor_unitario);
            $item->valor_solicitado = convertToMoneyBR($item->valor_solicitado);
            

            $value = $item;
            
        }
        $pedido->pedido_valor_total = convertToMoneyBR($pedido_valor_total);
        $pedido->pedido_quantidade_total =  $pedido_quantidade_total;
        return $pedido;
    }


    /**
     * Atualiza pregão item quando salva pedido
     */
    function savePedido($itens_pedido) {

        pr($itens_pedido);
        die;
        $saveAll = array();
        foreach($itens_pedido as $item_id => $quantidade) {
            $item = $this->pregaoItem->findById($item_id);

            $item->qtd_disponivel -= $quantidade;
            $item->qtd_solicitada += $quantidade;
            $item->valor_solicitado += $quantidade * $item->valor_unitario;
            if($item->qtd_disponivel < 0) {
                loadException("QUANTIDADE DO ITEM $item->nome INDISPONÍVEL");
            } else {
                $saveAll[] = $item;
            }
        }

        pr($saveAll);
        die;

        if(count($saveAll) > 0) {
            $this->pregaoItem->saveAll($saveAll);
        }
    }

    // /**
    //  * Soma um único item do pregão
    //  */
    // function sumItemPregao($item) {
    //     $this->objectPregao = $this->pregao->findById($item->pregao_id);
    //     $this->sumPregao($item);
    //     $this->pregao->save((array) $this->objectPregao);
    // }

    // /**
    //  * Subtrai um único item do pregão
    //  */
    // function subtractItemPregao($item) {
    //     $this->objectPregao = $this->pregao->findById($item->pregao_id);
    //     $this->subtractPregao($item);
    //     $this->pregao->save((array) $this->objectPregao);
    // }

    // /**
    //  * Atualiza um único item do pregão
    //  */
    // function updateItemPregao($item) {
    //     $this->objectPregao = $this->pregao->findById($item->pregao_id);
    //     $this->subtractPregao($item);
    //     $this->sumPregao($item);
    //     $this->pregao->save((array) $this->objectPregao);
    // }

    // /**
    //  * Zera valor dos itens do pregão.
    //  */
    // function resetItensPregao($pregao_id) {
    //     $this->objectPregao = $this->pregao->findById($pregao_id);
    //     $this->objectPregao->valor_total = 0.0;
    //     $this->objectPregao->qtd_total = 0;
    //     $this->objectPregao->qtd_disponivel = 0;
    //     $this->objectPregao->valor_solicitado = 0;
    //     $this->pregao->save((array) $this->objectPregao);
    // }


    // /**
    //  * Soma respectivamente:
    //  * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
    //  * Pregao     qtd_total, qtd_disponivel, valor_total
    //  */
    // function sumPregao($item) {
    //     if(empty($this->objectPregao)) {
    //         loadException("'objectPregao' não definido");
    //     }
    //     $this->objectPregao->valor_total += (convertCommaToDot($item->valor_unitario) * $item->qtd_total);
    //     $this->objectPregao->qtd_total += $item->qtd_total;
    //     if($item->qtd_disponivel > 0) {
    //         $this->objectPregao->qtd_disponivel += $item->qtd_disponivel;
    //     } else {
    //         $this->objectPregao->qtd_disponivel += $item->qtd_total;
    //     }
    //     if($item->qtd_solicitada > 0) {
    //         $this->objectPregao->valor_solicitado += ($item->qtd_solicitada * $item->valor_unitario);
    //     } else {
    //         $this->objectPregao->valor_solicitado += $item->valor_solicitado;
    //     }
    // }

    // /**
    //  * Subtrai respectivamente:
    //  * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
    //  * Pregao     qtd_total, qtd_disponivel, valor_total
    //  */
    // function subtractPregao($item) {
    //     if(empty($this->objectPregao)) {
    //         loadException("Pregão não definido incluir 'setPregao(pregao)'");
    //     }
    //     $this->objectPregao->valor_total -= (convertCommaToDot($item->valor_unitario) * $item->qtd_total);
    //     $this->objectPregao->qtd_total -= $item->qtd_total;
    //     if($item->qtd_disponivel > 0) {
    //         $this->objectPregao->qtd_disponivel -= $item->qtd_disponivel;
    //     } else {
    //         $this->objectPregao->qtd_disponivel -= $item->qtd_total;
    //     }        
    //     $this->objectPregao->valor_solicitado -= ($item->qtd_solicitada * $item->valor_unitario);
    // }
}
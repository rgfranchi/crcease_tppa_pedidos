<?php
namespace TPPA\APP\component;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once('helper/ItemPregaoHelper.php');

/**
 * Realiza calculo com os itens do pregão.

 */
class ItemPregaoCalculationComponent extends BasicComponent
{
    /**
     * Calcula quantidade de itens disponíveis<br>
     * Se o valor do item cadastrado for menor que zero, retorna zero.<br>
     * Inclui parâmetro qtd_disponível = qtd_total + SOMA(pedidos)
     * ex: $this->item_pregao_calculation->executeFunction("disponiveis", ['pedidos' => $pedidos, 'pregao_id' => $pregao_id]); 
     * Inclui parâmetro qtd_disponivel 
     * @param $pregao_itens itens do objeto pregão
     * @param $params array 'pedidos' de PedidoPregaoDomain e 'pregao_id'.
     */
    function disponiveis($data, $params) {
        $basicFunctions = new BasicFunctions();

        $pregao_itens = $data->findBy(["pregao_id", "==", $params['pregao_id']],['cod_item_pregao' => 'asc']);

        $total_itens_pedido = array();
        // Seleciona o total de itens dos pregão que já foi solicitado.
        foreach($params['pedidos'] as $pedido) {
            // if($pedido->status === "EMPENHADO" || $pedido->status === "EXCLUIDO") {
            if($pedido->status === "EXCLUIDO") {
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
        // cria coluna quantidade disponível igual a total.
        if(empty($total_itens_pedido)) {
            foreach($pregao_itens as &$value) {
                $value['qtd_disponivel'] = $value['qtd_total'];
                $value = (object) $value;
            }
            return $pregao_itens;
        }
        
        $ret = array();
        foreach($pregao_itens as $key => $object) {
            $values = clone((Object) $object);
            $values->qtd_disponivel = $values->qtd_total;
            if(isset($total_itens_pedido[$values->_id])) {
                $values->qtd_disponivel -= $total_itens_pedido[$values->_id];
                if($values->qtd_disponivel < 0) {
                    $this->invalidItem[$values->_id] = $values;
                   // $values->qtd_disponivel = 0;
                }
            } 
            // realiza conversão de exibição.
            $values->valor_unitario = $basicFunctions->convertToMoneyBR($values->valor_unitario);
            $ret[$key] = $values;
        }
        return $ret;
    }
}
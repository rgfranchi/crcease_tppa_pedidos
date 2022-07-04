<?php
namespace TPPA\APP\component;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once('helper/ItemPregaoHelper.php');

/**
 * Realiza calculo com os itens do pregão.

 */
class PedidoPregaoStatusComponent extends BasicComponent
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
    function qtd_pedidos($data, $params) {
        $pregao = $params['pregao'];
        foreach($pregao as &$value) {
            $pedidos = $data->findBy(["pregao_id", "==", $value->_id]);
            $count['rascunho'] = 0;
            $count['aprovado'] = 0;
            $count['concluido'] = 0;
            foreach($pedidos as $valuePedido) {
                switch($valuePedido['status']) {
                    case "EMPENHADO" :
                        $count['concluido']++;                    
                    case "EMPENHO SOLICITADO" :    
                    case "CREDITADO" :
                    case "CREDITO SOLICITADO" :                            
                    case "APROVADO" :
                        $count['aprovado']++;
                    case "AGUARDANDO APROVAÇÃO":
                    case "RASCUNHO" :
                         $count['rascunho']++;
                }
            }
            $value->qtd_pedidos = $count['rascunho'] . "/" . $count['aprovado'] . "/" . $count['concluido'];            
        }
        return $pregao;
    }
}
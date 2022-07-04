<?php
namespace TPPA\APP\repository;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\repository\BasicRepository;

use function TPPA\CORE\basic\pr;

class ItemPregaoRepository extends BasicRepository
{

    private $invalidItem = array();

    function __construct() {
        parent::__construct("ItemPregao");
    }

    /**
     * Calcula quantidade de itens disponíveis<br>
     * Se o valor do item cadastrado for menor que zero, retorna zero.<br>
     * Inclui parâmetro qtd_disponível = qtd_total + SOMA(pedidos)
     * ex: $this->item_pregao_calculation->executeFunction("disponiveis", ['pedidos' => $pedidos, 'pregao_id' => $pregao_id]); 
     * Inclui parâmetro qtd_disponivel 
     * @param $pregao_itens itens do objeto pregão
     * @param $params array 'pedidos' de PedidoPregaoDomain e 'pregao_id'.
     * @param $isConvert boolean convert valor de float para BR.
     */
    function addQtd_disponivel($pregao_id, $pedido_pregao_id = null, $isConvert = true) {
        $basicFunctions = new BasicFunctions();
        $this->pedidoPregaoRepository = $this->subRepository("PedidoPregao");

        $pregao_itens = $this->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $pedido_condition = ["pregao_id", "==", $pregao_id];
        if(!is_null($pedido_pregao_id)) {
            $pedido_condition = [
                ["pregao_id", "==", $pregao_id],
                "AND",
                [ "_id","<>",$pedido_pregao_id]
            ];
        } 
        $pedidos = $this->pedidoPregaoRepository->findBy($pedido_condition);

        $total_itens_pedido = array();
        // Calcula o total de itens dos pregão que já foi solicitado.
        foreach($pedidos as $pedido) {
            if($pedido['status'] === "EXCLUIDO") {
                continue;
            }
            if(empty($pedido['itens_pedido'])) {
                continue;
            }
            foreach($pedido['itens_pedido'] as $key => $values) {
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
                // $value = (object) $value;
            }
            return $pregao_itens;
        }
        
        $ret = array();
        foreach($pregao_itens as $key => $values) {
            $values['qtd_disponivel'] = $values['qtd_total'];
            // $values['qtd_disponivel'] = -1; teste invalido.... 
            if(isset($total_itens_pedido[$values['_id']])) {
                $values['qtd_disponivel'] -= $total_itens_pedido[$values['_id']];
                if($values['qtd_disponivel'] < 0) {
                    $this->invalidItem[$values['_id']] = $values;
                   // $values->qtd_disponivel = 0;
                }
            } 
            // realiza conversão de exibição.
            if($isConvert) {
                $values['valor_unitario'] = $basicFunctions->convertToMoneyBR($values['valor_unitario']);
            }
            $ret[$key] = $values;
        }
        return $ret;
    }

    function getInvalidItem() {
        return $this->invalidItem;
    }

    function optionsFields() {

        $basicFunctions = new BasicFunctions();
        $newComponent = array();
        foreach(array_keys((array) $this->getDomain()) as $keys) {
            switch($keys) {
                case "_id":
                    $newComponent[$keys] = "_ID DO SISTEMA";
                case "pregao_id":
                    continue;
                case 'qtd_total':
                case 'cod_item_pregao' :
                case 'descricao' : 
                case 'valor_unitario' :
                    $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys)." *";
                    break;          
                default:
                $newComponent[$keys] = $basicFunctions->snakeToTextCase($keys);
            }
        }
        return $newComponent;
    }

    /**
     * Realiza a junção do ItemPregao com PedidoPregao.
     * Campo 'pedido' Inclui coluna 'quantidade' e exclui 'itens_pedido'.
     * 
     * @param $pregao_id 
     * @param $conditions_pedido condição da subquery de pedidos.
     * @param $conditions_item condição de pedidos.
     * @return $pedidos realizados por item.
     */
    function joinsPedidos($conditions_pedido = [], $conditions_item = []) {
        $pedidoPregaoRepository = new PedidoPregaoRepository();
        $item_pregao = $this->getStore()
            ->createQueryBuilder()
            ->where($conditions_item)
            ->join(function($item) use ($pedidoPregaoRepository, $conditions_pedido)  {
                $query_pedido = ['pregao_id','==', $item['pregao_id']];
                if(!empty($conditions_pedido)) {
                    $query_pedido = array_merge(
                        [$query_pedido], $conditions_pedido
                    );
                } 
                $pedidosPregao = $pedidoPregaoRepository->findBy($query_pedido);
                $ret = array();
                // realiza busca pela chave do array 'itens_pedido'
                foreach($pedidosPregao as &$pedido) {
                    // retira valores do array igual a zero.
                    $pedido['itens_pedido'] = array_filter($pedido['itens_pedido']);
                    // recebe id dos itens relacionados aos pedidos.
                    $itens_id = array_keys($pedido['itens_pedido']);
                    // se a chave do item está no pedido.
                    if (in_array($item['_id'], $itens_id)) {
                        $ret[$pedido['_id']] = $pedido;
                        $ret[$pedido['_id']]['quantidade'] = $pedido['itens_pedido'][$item['_id']];
                        unset($ret[$pedido['_id']]['itens_pedido']);
                    }
                }
                return $ret;
            }, 'pedidos')
            ->getQuery()
            ->fetch();
        return $item_pregao;     
    }


    /**
     * Exclui todos os registros vinculados ao pregão.
     * @param int _id do pregão que contem os itens.
     */
    function deleteAll($pregao_id)
    {
        return $this->deleteBy(["pregao_id","==",$pregao_id]);
    }

}
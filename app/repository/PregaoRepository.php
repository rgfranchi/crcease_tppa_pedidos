<?php
namespace TPPA\APP\repository;

use DateTime;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\repository\BasicRepository;

use function TPPA\CORE\basic\pr;

class PregaoRepository extends BasicRepository
{
    function __construct() 
    {
        parent::__construct("Pregao");
    }

    /**
     * Busca Pregão pelo _id do item.
     * @param int _id do pregão que contem os itens.
     */
    function findPregaoByItemId($item_id)
    {
        $itemPregaoRepository = $this->subRepository("ItemPregao");
        $domain = $this->getStore();
        $join = $itemPregaoRepository->getStore()->createQueryBuilder()->join(function ($pregao) use ($domain) {
            return $domain->findById($pregao['pregao_id']);
        }, 'pregao')
            ->where(['_id','==', $item_id])
            ->getQuery()
            ->first();
        $ret['pregao'] = $join['pregao'];
        $ret['item'] = $join;
        return $ret;
    }

    // function addData_vencimento_color($pregao_id) {
    //     $this->disableAfterRead(true);
    //     $pregao = $this->findById($pregao_id);
    //     $dateNow = new DateTime();
    //     $dateVencimento = new DateTime($pregao['data_limite_solicitacao']); 
    //     $diff = $dateNow->diff($dateVencimento);
    //     $pregao['data_vencimento_color'] = "green";

    //     pr($pregao);
    //     pr($dateNow);
    //     pr($dateVencimento);
    //     pr($diff);
    //     die;

    //     if($diff->invert == 1) {
    //         $pregao['data_vencimento_color'] = "red";
    //     } else {
    //         if($diff->m < 3) {
    //             $pregao['data_vencimento_color'] = "#DAA520";
    //         }
    //     }
    //     $this->disableAfterRead(false);
    //     $pregao = $this->getDomain()->afterRead($pregao);

    //     return $pregao;
    // }

    /**
     * Realiza a junção do Pregao com PedidoPregao.
     * 
     * @param $conditions_pregao condição de busca do pregão 
     * @param $conditions_pedido condição da subquery de pedidos.
     * @return $pedidos realizados por pregão.
     */
    function joinPedidos($conditions_pregao = [], $conditions_pedido = []) {
        $query_pregao = empty($conditions_pregao) ? ['_id','>','0'] : $conditions_pregao;
        $pedidoPregaoRepository = new PedidoPregaoRepository();
        $pregao = $this->getStore()
            ->createQueryBuilder()
            ->where($query_pregao)
            ->join(function($item) use ($pedidoPregaoRepository, $conditions_pedido)  {
                $query_pedido = ['pregao_id','==', $item['_id']];
                if(!empty($conditions_pedido)) {
                    $query_pedido = array_merge(
                        [$query_pedido], $conditions_pedido
                    );
                } 
                return $pedidoPregaoRepository->findBy($query_pedido);
            }, 'pedidos')
            ->getQuery()
            ->fetch();   
        return $pregao;
    }

    /**
     * Inclui campo 'data_vencimento_color':<br>
     * cor para destaque das datas de vencimento <br>
     * (vermelho:vencido, amarelo: 3 meses para vencer)
     * @param $pregao (null) array pregao se null retorna todos.
     * @param $conditions_pregao (['_id','>','0']) condição de busca se o primeiro parametro for null.
     */
    function addData_vencimento_color($pregaoJoinPedidos = [], $conditions_pregao = []) {
        if(empty($pregaoJoinPedidos)) {
            $this->disableAfterRead(true);
            $query_pregao = empty($conditions_pregao) ? ['_id','>','0'] : $conditions_pregao;
            $pregaoJoinPedidos = $this->findBy($query_pregao);
        }
        $dateNow = new DateTime();
        foreach($pregaoJoinPedidos as &$value) {
            $dateVencimento = new DateTime($value['data_limite_solicitacao']); 
            $diff = $dateNow->diff($dateVencimento);
            $value['data_vencimento_color'] = "green";
            if($diff->invert == 1) {
                $value['data_vencimento_color'] = "red";
            } else {
                if($diff->m < 3) {
                    $value['data_vencimento_color'] = "#DAA520";
                }
            }
            $value = $this->getDomain()->afterRead($value);
        }

        // $this->disableAfterRead(true);
        // $pregao = $this->findById($pregao_id);
        // $dateNow = new DateTime();
        // $dateVencimento = new DateTime($pregao['data_limite_solicitacao']); 
        // $diff = $dateNow->diff($dateVencimento);
        // $pregao['data_vencimento_color'] = "green";

        // pr($pregao);
        // pr($dateNow);
        // pr($dateVencimento);
        // pr($diff);
        // die;

        // if($diff->invert == 1) {
        //     $pregao['data_vencimento_color'] = "red";
        // } else {
        //     if($diff->m < 3) {
        //         $pregao['data_vencimento_color'] = "#DAA520";
        //     }
        // }
        // $this->disableAfterRead(false);
        // $pregao = $this->getDomain()->afterRead($pregao);

        return $pregaoJoinPedidos;
    }


    /**
     * Adiciona quantidade de pedidos no pregão por status de cada pedido.
     * @param $pregao (null) array joinsPedidos se null retorna todos.
     */
    function addQtd_pedidos($pregaoJoinPedidos = null) {
        if(empty($pregaoJoinPedidos)) {
            $pregaoJoinPedidos = $this->joinPedidos();
        }
        foreach($pregaoJoinPedidos as &$value) {
            $count['rascunho'] = 0;
            $count['aprovado'] = 0;
            $count['concluido'] = 0;
            foreach($value['pedidos'] as $valuePedido) {
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
            $value['qtd_pedidos'] = $count['rascunho'] . "/" . $count['aprovado'] . "/" . $count['concluido'];            
        }
        return $pregaoJoinPedidos;
    }
}
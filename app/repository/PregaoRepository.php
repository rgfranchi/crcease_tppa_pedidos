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
        $this->loadService("PesquisarPedidoPregao");
    }

    /**
     * Busca Pregão pelo _id do item.
     * @param int _id do pregão que contem os itens.
     */
    function findPregaoByItemId($item_id)
    {
        $itemPregaoRepository = new ItemPregaoRepository();
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

    /**
     * busca por "find_value".
     * PregaoDomain - nome / objeto / termo_referencia_origem / numero_processo_PAG
     * ItemPregaoDomain - cod_item_pregao / descricao / fornecedor
     * PedidoPregaoDomain - setor / solicitante
     */
    function findPregao($find,  $where_pregao = ['ativo', '==', 'true']) {
        
        if($this->pesquisar_pedido_pregao->findConvert($find) === false) {
            return array();
        }
        $itemPregaoRepository = new ItemPregaoRepository();
        $pedidoPregaoRepository = new PedidoPregaoRepository();
        $res = $this->getStore()
            ->createQueryBuilder()
            ->join(function($pregao) use ($itemPregaoRepository) {
                return $itemPregaoRepository->findBy(["pregao_id", "==", $pregao["_id"]]);
            } ,"item_pregao")
            ->join(function($pregao) use ($pedidoPregaoRepository) {
                return $pedidoPregaoRepository->findBy([
                    ["pregao_id", "==", $pregao["_id"]],
                    ["status", "!=", "EXCLUIDO"]
                ]);
            },"pedido_pregao")
            ->where([
                ['nome', 'LIKE', $find],
                'OR',
                ['objeto', 'LIKE', $find],
                'OR',
                ['termo_referencia_origem', 'LIKE', $find],
                'OR',
                ['numero_processo_PAG', 'LIKE', $find],
            ])
            ->where($where_pregao)
            ->getQuery()
            ->fetch();
        return $res;
    }


    function findItemPregao($find, $where_pregao = ['ativo', '==', 'true']) {
        if($this->pesquisar_pedido_pregao->findConvert($find) === false) {
            return array();
        }
        $itemPregaoRepository = new ItemPregaoRepository();
        $pedidoPregaoRepository = new PedidoPregaoRepository();
        $res = $this->getStore()
            ->createQueryBuilder()
            ->join(function($pregao) use ($itemPregaoRepository, $find) {
                return $itemPregaoRepository->getStore()->createQueryBuilder()
                    ->where(["pregao_id", "==", $pregao["_id"]])
                    ->where([
                        ['descricao', 'LIKE', $find],
                        'OR',
                        ['fornecedor', 'LIKE', $find],
                        'OR',
                        ['natureza_despesa', 'LIKE', $find]
                    ])->getQuery()
                    ->fetch();
            } ,"item_pregao")
            ->join(function($pregao) use ($pedidoPregaoRepository) {
                return $pedidoPregaoRepository->findBy([
                    ["pregao_id", "==", $pregao["_id"]], 
                    ["status", "!=", "EXCLUIDO"]
                ]);
            },"pedido_pregao")
            ->where($where_pregao)
            ->getQuery()
            ->fetch();
        // Retira valor do resultado se não possuir item_pregao.
        foreach($res as $key => $values) {
            if(empty($values["item_pregao"])) {
                unset($res[$key]);
            }
        }
        return $res;
    }    


    function findPedidoPregao($find, $where_pregao = ['ativo', '==', 'true']) {
        if($this->pesquisar_pedido_pregao->findConvert($find) === false) {
            return array();
        }
        $itemPregaoRepository = new ItemPregaoRepository();
        $pedidoPregaoRepository = new PedidoPregaoRepository();

        $res = $this->getStore()
            ->createQueryBuilder()
            ->join(function($pregao) use ($itemPregaoRepository) {
                return $itemPregaoRepository->findBy(["pregao_id", "==", $pregao["_id"]]);
            } ,"item_pregao")
            ->join(function($pregao) use ($pedidoPregaoRepository, $find) {
                return $pedidoPregaoRepository->getStore()->createQueryBuilder()
                    ->where(["pregao_id", "==", $pregao["_id"]])
                    ->where(["status", "!=", "EXCLUIDO"])
                    ->where([
                        ['setor', 'LIKE', $find],
                        'OR',
                        ['solicitante', 'LIKE', $find],
                        'OR',
                        ['hashCredito', 'LIKE', $find],
                        'OR',
                        ['status', 'LIKE', $find],
                    ])
                    ->getQuery()
                    ->fetch();
            },"pedido_pregao")
            ->where($where_pregao)
            ->getQuery()
            ->fetch();
        // Retira valor do resultado se não possuir item_pregao.
        foreach($res as $key => $values) {
            if(empty($values["pedido_pregao"])) {
                unset($res[$key]);
            }
        }
        
        return $res;
    }

}
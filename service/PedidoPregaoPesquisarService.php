<?php

require_once(__ROOT__ . '/config.php');

class PedidoPregaoPesquisarService extends BasicSystem 
{

    private $pregao_store = null;
    private $pedido_pregao_store = null;
    private $item_pregao_store = null;

    function __construct()
    {
        $this->pregao_store = $this->loadBasicStores('Pregao')->getStore();
        $this->item_pregao_store = $this->loadBasicStores('ItemPregao')->getStore();
        $this->pedido_pregao_store = $this->loadBasicStores('PedidoPregao')->getStore();
    }

    /**
     * Verifica necessidade de ajuste na variável find.
     */
    function findConvert(&$find){
        if(empty($find)) {
            return false;
        } 
        $find = "%".str_replace("/",'%',trim($find))."%";
    }

    /**
     * busca por "find_value".
     * PregaoDomain - nome / objeto / termo_referencia_origem / numero_processo_PAG
     * ItemPregaoDomain - cod_item_pregao / nome / descricao / fornecedor
     * PedidoPregaoDomain - setor / solicitante
     */
    function findPregao($find,  $where_pregao = ['ativo', '==', 'true']) {
        
        if($this->findConvert($find) === false) {
            return array();
        }
        
        $res = $this->pregao_store
            ->createQueryBuilder()
            ->join(function($pregao) {
                return $this->item_pregao_store->findBy(["pregao_id", "==", $pregao["_id"]]);
            } ,"item_pregao")
            ->join(function($pregao) {
                return $this->pedido_pregao_store->findBy(["pregao_id", "==", $pregao["_id"]]);
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
        if($this->findConvert($find) === false) {
            return array();
        }
        $res = $this->pregao_store
            ->createQueryBuilder()
            ->join(function($pregao) use ($find) {
                return $this->item_pregao_store->createQueryBuilder()
                    ->where(["pregao_id", "==", $pregao["_id"]])
                    ->where([
                        ['nome', 'LIKE', $find],
                        'OR',
                        ['descricao', 'LIKE', $find],
                        'OR',
                        ['fornecedor', 'LIKE', $find],
                        'OR',
                        ['natureza_despesa', 'LIKE', $find]
                    ])->getQuery()
                    ->fetch();
            } ,"item_pregao")
            ->join(function($pregao) {
                return $this->pedido_pregao_store->findBy(["pregao_id", "==", $pregao["_id"]]);
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
        if($this->findConvert($find) === false) {
            return array();
        }

        $res = $this->pregao_store
            ->createQueryBuilder()
            ->join(function($pregao) {
                return $this->item_pregao_store->findBy(["pregao_id", "==", $pregao["_id"]]);
            } ,"item_pregao")
            ->join(function($pregao) use ($find) {
                return $this->pedido_pregao_store->createQueryBuilder()
                    ->where(["pregao_id", "==", $pregao["_id"]])
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
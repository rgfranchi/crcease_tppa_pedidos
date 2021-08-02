<?php

include_once('BasicStore.php');
include_once('PregaoStore.php');

class PregaoItemStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "PregaoItem");
    }


    function joinPregaoAndFindById($pregao_id)
    {
        $pregaoStore = new PregaoStore();
        $pregao = $pregaoStore->getStore();
        $itens = $this->store;
        $join = $pregao->createQueryBuilder()->join(function ($value) use ($itens) {
            // returns result
            return $itens->findBy(["pregao_id", "=", $value["_id"]]);
        }, "itens")
            ->where(['_id', '==', $pregao_id])
            ->getQuery()
            ->first();
        return $this->arrayToDomainObject($join);
    }

    function findPregaoByItemId($item_id)
    {
        $pregaoStore = new PregaoStore();
        $pregoes = $pregaoStore->getStore();
        $itens = $this->store;
        $join = $itens->createQueryBuilder()->join(function ($pregao) use ($pregoes) {
            // returns result
            pr($pregao);
            return $pregoes->findById($pregao['pregao_id']);
        }, "pregao")
            ->where(['_id', '==', $item_id])
            ->getQuery()
            ->first();
        return $this->arrayToDomainObject($join);
    }
}

<?php

include_once('BasicStore.php');

class PregaoItemStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "PregaoItem");
        $this->loadBasicStores("Pregao");
        $this->loadService('PregaoCalculation');
    }

    function joinPregaoAndFindById($pregao_id)
    {
        $pregao = $this->pregao->getStore();
        $itens = $this->store;
        $join = $pregao->createQueryBuilder()->join(function ($value) use ($itens) {
            return $itens->findBy(["pregao_id", "==", $value["_id"]]);
        }, 'itens')
            ->where(['_id', '==', $pregao_id])
            ->disableCache()
            ->getQuery()
            ->first();
        $joinPregaoItem = $this->arrayToDomainObject($join, $this->pregao->pregao);
        $joinPregaoItem->itens = $this->arrayToDomainObject($join['itens']);
        return $joinPregaoItem;
    }

    function findPregaoByItemId($item_id)
    {
        $pregoes = $this->pregao->getStore();
        $itens = $this->store;
        $join = $itens->createQueryBuilder()->join(function ($pregao) use ($pregoes) {
            return $pregoes->findById($pregao['pregao_id']);
        }, 'pregao')
            ->where(['_id', '==', $item_id])
            ->getQuery()
            ->first();
        $joinPregaoItem = $this->arrayToDomainObject($join);
        $joinPregaoItem->pregao = $this->arrayToDomainObject($join['pregao'], $this->pregao->pregao);
        return $joinPregaoItem;
    }

    function create($object)
    {
        $savedItem = parent::create($object);
        $this->pregao_calculation->sumItemPregao($savedItem);
    }

    function update($object)
    {
        $old_item = $this->findById($object['_id']);
        $this->pregao_calculation->subtractItemPregao($old_item);
        $savedItem = parent::update($object);
        $this->pregao_calculation->sumItemPregao($savedItem);
    }

    function delete($item)
    {
        $this->pregao_calculation->subtractItemPregao($item);        
        parent::delete($item->_id);
    }

}

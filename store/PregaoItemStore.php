<?php

include_once('BasicStore.php');

class PregaoItemStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "PregaoItem");
        $this->loadBasicStores("Pregao");
        $this->loadComponent("PregaoHead");
        $this->loadService('PregaoCalculation');
    }

    function findPregaoByItemId($item_id)
    {
        $pregoes = $this->pregao->store;
        $join = $this->store->createQueryBuilder()->join(function ($pregao) use ($pregoes) {
            return $pregoes->findById($pregao['pregao_id']);
        }, 'pregao')
            ->where(['_id', '==', $item_id])
            ->getQuery()
            ->first();
          
        $ret['pregao'] = $this->arrayToObject($join['pregao'], $this->pregao_head);
        $ret['item'] = $this->arrayToObject($join,$this->domain);
        return $ret;
    }

    function create($object)
    {
        $savedItem = parent::create($object);
        $this->pregao_calculation->sumItemPregao($savedItem);
    }

    function update($object)
    {
        $old_item = $this->findById($object['_id']);
        if(!empty($old_item)) { // caso tenha excluido os itens e recadastrado com mesmo _id
            $this->pregao_calculation->subtractItemPregao($old_item);
        }
        $savedItem = parent::update($object);
        $this->pregao_calculation->sumItemPregao($savedItem);
    }

    function delete($del_item)
    {
        $this->pregao_calculation->subtractItemPregao($del_item);        
        return parent::delete($del_item->_id);
    }

    function deleteAll($pregao_id)
    {
        $this->pregao_calculation->resetItensPregao($pregao_id);        
        return $this->store->deleteBy(['pregao_id',"==",$pregao_id]);
    }

}

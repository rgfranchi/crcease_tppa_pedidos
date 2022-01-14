<?php

include_once('BasicStore.php');

class ItemPregaoStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "ItemPregao");
        $this->loadBasicStores("Pregao");
        $this->loadComponent("PregaoHead");
        // $this->loadService('PregaoCalculation');
    }

    /**
     * Busca Pregão pelo _id do item.
     * @param int _id do pregão que contem os itens.
     */
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

    /**
     * Exclui todos os registros vinculados ao pregão.
     * @param int _id do pregão que contem os itens.
     */
    function deleteAll($pregao_id)
    {
        // $this->pregao_calculation->resetItensPregao($pregao_id);        
        return $this->store->deleteBy(["pregao_id","==",$pregao_id]);
    }

    // function create($object)
    // {
    //     $savedItem = parent::create($object);
    //     $this->pregao_calculation->sumItemPregao($savedItem);
    // }

    // function update($object)
    // {
    //     $old_item = $this->findById($object['_id']);
    //     if(!empty($old_item)) { // caso tenha excluido os itens e recadastrado com mesmo _id
    //         $this->pregao_calculation->subtractItemPregao($old_item);
    //     }
    //     $savedItem = parent::update($object);
    //     $this->pregao_calculation->sumItemPregao($savedItem);
    // }

    // function delete($del_item)
    // {
    //     $this->pregao_calculation->subtractItemPregao($del_item);        
    //     return parent::delete($del_item->_id);
    // }



}

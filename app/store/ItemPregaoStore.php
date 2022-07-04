<?php
namespace TPPA\APP\store;

use TPPA\CORE\store\BasicStore;

use function TPPA\CORE\basic\pr;

// include_once('BasicStore.php');

class ItemPregaoStore extends BasicStore
{
    function __construct()
    {
        parent::__construct("ItemPregaoStore", "ItemPregao");
        $this->loadBasicStores("Pregao");
    }

    // /**
    //  * Busca Pregão pelo _id do item.
    //  * @param int _id do pregão que contem os itens.
    //  */
    // function findPregaoByItemId($item_id)
    // {
    //     $pregoes = $this->pregao->store;
    //     $join = $this->store->createQueryBuilder()->join(function ($pregao) use ($pregoes) {
    //         return $pregoes->findById($pregao['pregao_id']);
    //     }, 'pregao')
    //         ->where(['_id', '==', $item_id])
    //         ->getQuery()
    //         ->first();
    //     $ret['pregao'] = (object) $join['pregao'];
    //     $ret['item'] = (object) $join;
    //     return $ret;
    // }

    /**
     * Exclui todos os registros vinculados ao pregão.
     * @param int _id do pregão que contem os itens.
     */
    function deleteAll($pregao_id)
    {
        return $this->store->deleteBy(["pregao_id","==",$pregao_id]);
    }
}

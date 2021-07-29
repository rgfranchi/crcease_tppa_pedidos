<?php

include_once('BasicStore.php');
include_once('PregaoStore.php');

class PregaoItemStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "PregaoItens");
    }


    function joinPregaoAndfindById($pregao_id) {
        $pregaoStore = new PregaoStore();
        $pregao = $pregaoStore->getStore();
        $itens = $this->store;
        $join = $pregao->createQueryBuilder()->join(function($value) use ($itens){
            // returns result
            return $itens->findBy([ "pregoes_id", "=", $value["_id"] ]);
          }, "itens")
          ->where(['_id','==',$pregao_id])
          ->getQuery()
          ->fetch();
        return $this->arrayToDomainObject($join);
    }

}

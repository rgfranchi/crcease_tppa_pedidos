<?php

include_once 'BasicStore.php';

class PregaoStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, 'Pregao');
    }

    function save($object)
    {
        $object->valor_total = convertCommaToDot($object->valor_total);
        $object->valor_solicitado = convertCommaToDot($object->valor_solicitado);
        parent::save($object);
    }
}

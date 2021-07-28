<?php

include_once 'BasicStore.php';

class PregaoItemStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, "PregaoItens");
    }
}

<?php

include_once 'BasicStore.php';

class PregaoStore extends BasicStore
{
    function __construct()
    {
        parent::__construct(__CLASS__, 'Pregao');
    }
}

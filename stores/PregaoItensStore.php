<?php

include_once 'BasicStore.php';

class PregaoItensStore extends BasicStore {
    function __construct()
    {
        parent::__construct(__CLASS__,"PregaoItens");
    }
}
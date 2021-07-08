<?php

include 'BasicStore.php';

class PregaoStore extends BasicStore {
    
    function __construct() {
        parent::__construct(__CLASS__);
    }

    function addItens($pregoesItens) {
        $this->itens[] = $pregoesItens;
    }
}
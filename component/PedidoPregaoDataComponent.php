<?php

include_once('BasicComponent.php');

class PedidoPregaoDataComponent extends BasicComponent
{
    public $_id;
    public $pregao_id;
    public $setor;
    public $solicitante;

    /**
     * Array <br>
     * key -> pregao_item_id<br>
     * value -> quantidade
     */
    public $itens_id;
}
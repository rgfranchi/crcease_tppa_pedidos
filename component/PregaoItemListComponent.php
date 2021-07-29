<?php

// namespace Domain;
class PregaoItemListComponent
{
    public $pregao_id;
    public $pregao_nome;
    public $itens;
    // public $itens = array(new class {
    //     public $nome;
    //     public $descricao;
    //     public $valor_unitario;
    //     public $qtd_disponivel; 
    // });

    function addItem($item){
        $this->itens[] = new $item;
    }
}

class Item {
    public $nome;
    public $descricao;
    public $valor_unitario;
    public $qtd_disponivel; 
}
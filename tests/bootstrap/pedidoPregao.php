<?php

$pedido_pregao_item_delete = new BasicStore('PedidoPregaoStore','PedidoPregao');
$pedido_pregao_item_delete->getStore()->deleteStore();

$pedido_pregao_item = new BasicStore('PedidoPregaoStore','PedidoPregao');
$id = 0;

$pedido_pregao_item_1 = new PedidoPregaoDomain();
$pedido_pregao_item_1->_id = ++$id;
$pedido_pregao_item_1->pregao_id = 1;
$pedido_pregao_item_1->setor = "TPPA";
$pedido_pregao_item_1->solicitante = "3S Marcos";
$pedido_pregao_item_1->itens_id = array(
    "2" => 7,
    "4" => 5,
    "6" => 3,
    "8" => 1,
    "10" => 9,
);
pr($pedido_pregao_item_1);
$pedido_pregao_item->update((array) $pedido_pregao_item_1);

$pedido_pregao_item_2 = new PedidoPregaoDomain();
$pedido_pregao_item_2->_id = ++$id;
$pedido_pregao_item_2->pregao_id = 1;
$pedido_pregao_item_2->setor = "TPPA";
$pedido_pregao_item_2->solicitante = "3S Marcos";
$pedido_pregao_item_2->itens_id = array(
    "2" => 10,
    "4" => 20,
    "6" => 30,
    "7" => 40,
    "8" => 50,
);
pr($pedido_pregao_item_2);
$pedido_pregao_item->update((array) $pedido_pregao_item_2);

$pedido_pregao_item_3 = new PedidoPregaoDomain();
$pedido_pregao_item_3->_id = ++$id;
$pedido_pregao_item_3->pregao_id = 3;
$pedido_pregao_item_3->setor = "TPPA";
$pedido_pregao_item_3->solicitante = "3S Marcos";
$pedido_pregao_item_3->itens_id = array(
    "2" => 3,
    "5" => 1,
    "7" => 2,
    "9" => 3,
    "14" => 1,
);
pr($pedido_pregao_item_3);
$pedido_pregao_item->update((array) $pedido_pregao_item_3);



// pr($pregao_2_itens_1);
// $pedido_pregao_item->update((array) $pregao_2_itens_1);

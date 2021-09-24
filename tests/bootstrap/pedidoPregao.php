<?php

$pedido_pregao_item_delete = new BasicStore('PedidoPregaoStore','PedidoPregao');
$pedido_pregao_item_delete->getStore()->deleteStore();

$pedido_pregao2_item = new BasicStore('PedidoPregaoStore','PedidoPregao');
$id = 0;

$pedido_pregao2_item_1 = new PedidoPregaoDomain();
$pedido_pregao2_item_1->_id = ++$id;
$pedido_pregao2_item_1->pregao_id = 2;
$pedido_pregao2_item_1->setor = "TPPA";
$pedido_pregao2_item_1->solicitante = "PEDIDO 1";
$pedido_pregao2_item_1->status = "CRIADO";
$pedido_pregao2_item_1->itens_pedido = array(
    "2" => 5,
    "4" => 5,
    "6" => 5,
);
pr($pedido_pregao2_item_1);
$pedido_pregao2_item->create_update_object((array) $pedido_pregao2_item_1);

$pedido_pregao2_item_2 = new PedidoPregaoDomain();
$pedido_pregao2_item_2->_id = ++$id;
$pedido_pregao2_item_2->pregao_id = 2;
$pedido_pregao2_item_2->setor = "TPPA";
$pedido_pregao2_item_2->solicitante = "PEDIDO 2";
$pedido_pregao2_item_2->status = "CRIADO";
$pedido_pregao2_item_2->itens_pedido = array(
    "1" => 10,
    "3" => 20,
    "5" => 30,
);
pr($pedido_pregao2_item_2);
$pedido_pregao2_item->create_update_object((array) $pedido_pregao2_item_2);

$pedido_pregao2_item_3 = new PedidoPregaoDomain();
$pedido_pregao2_item_3->_id = ++$id;
$pedido_pregao2_item_3->pregao_id = 2;
$pedido_pregao2_item_3->setor = "TPPA";
$pedido_pregao2_item_3->solicitante = "PEDIDO 3";
$pedido_pregao2_item_3->status = "CRIADO";
$pedido_pregao2_item_3->itens_pedido = array(
    "1" => 2,
    "2" => 2,
    "3" => 2,
    "4" => 2,
    "5" => 2,
    "6" => 2,
    "7" => 2,
);
pr($pedido_pregao2_item_3);
$pedido_pregao2_item->create_update_object((array) $pedido_pregao2_item_3);
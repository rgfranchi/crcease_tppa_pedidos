<?php

include_once $app_path . '/store/PregaoItemStore.php';

$pregao_item_store = new PregaoItemStore();

$pregao_itens_1 = new PregaoItens();
$pregao_itens_1->_id = 1;
$pregao_itens_1->nome = "Fio de baixa tensão";
$pregao_itens_1->descricao = "Fio de 10A com .... ";
$pregao_itens_1->qtd_disponivel = 100;
$pregao_itens_1->qtd_solicitada = 80;
$pregao_itens_1->qtd_total = 180;
$pregao_itens_1->valor_unitario = '150,00';
$pregao_itens_1->valor_solicitado = '12000,00';

pr($pregao_itens_1);

$pregao_item_store->update($pregao_itens_1);

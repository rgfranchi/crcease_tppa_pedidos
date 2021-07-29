<?php

include_once $app_path . '/store/PregaoItemStore.php';

$id = 1;

$pregao_item_store = new PregaoItemStore();

$pregao_1_itens_1 = new PregaoItens();
$pregao_1_itens_1->_id = $id;
$pregao_1_itens_1->pregoes_id = 1;
$pregao_1_itens_1->nome = "Fio de baixa tensão";
$pregao_1_itens_1->descricao = "Fio de 10A com .... ";
$pregao_1_itens_1->qtd_disponivel = 100;
$pregao_1_itens_1->qtd_solicitada = 80;
$pregao_1_itens_1->qtd_total = 180;
$pregao_1_itens_1->valor_unitario = '150,00';
$pregao_1_itens_1->valor_solicitado = '12000,00';

pr($pregao_1_itens_1);
$pregao_item_store->update($pregao_1_itens_1);

$pregao_1_itens_2 = new PregaoItens();
$pregao_1_itens_2->_id = ++$id;
$pregao_1_itens_2->pregoes_id = 1;
$pregao_1_itens_2->nome = "Conector tipo macho para fio de baixa tensão";
$pregao_1_itens_2->descricao = "Conector para fio de 10A com .... ";
$pregao_1_itens_2->qtd_disponivel = 1000;
$pregao_1_itens_2->qtd_solicitada = 800;
$pregao_1_itens_2->qtd_total = 1800;
$pregao_1_itens_2->valor_unitario = '15,00';
$pregao_1_itens_2->valor_solicitado = '1200,00';
pr($pregao_1_itens_2);
$pregao_item_store->update($pregao_1_itens_2);

$pregao_2_itens_1 = new PregaoItens();
$pregao_2_itens_1->_id = ++$id;
$pregao_2_itens_1->pregoes_id = 2;
$pregao_2_itens_1->nome = "Coleta de lixo - residencial , comercial , industrial";
$pregao_2_itens_1->descricao = "Coleta de lixo";
$pregao_2_itens_1->qtd_disponivel = 2112;
$pregao_2_itens_1->qtd_solicitada = 80;
$pregao_2_itens_1->qtd_total = 2112;
$pregao_2_itens_1->valor_unitario = '38,88';
$pregao_2_itens_1->valor_solicitado = '82114,56';

pr($pregao_2_itens_1);
$pregao_item_store->update($pregao_2_itens_1);
<?php

$pregao_item_store = new BasicStore('PregaoItemStore','PregaoItem');

$id = 0;

$pregao_1_itens_1 = new PregaoItemDomain();
$pregao_1_itens_1->_id = ++$id;
$pregao_1_itens_1->pregao_id = 1;
$pregao_1_itens_1->cod_item_pregao = 1;
$pregao_1_itens_1->nome = "Tinta acrílica";
$pregao_1_itens_1->descricao = "MARCA CORTEX";
$pregao_1_itens_1->valor_unitario = 64.00;
$pregao_1_itens_1->valor_solicitado = 12000.00;
$pregao_1_itens_1->qtd_total = 714;
$pregao_1_itens_1->qtd_disponivel = 606;
$pregao_1_itens_1->qtd_solicitada = 108;
$pregao_1_itens_1->unidade = 'Litro';
$pregao_1_itens_1->fornecedor = '28.040.796/0001-25 - SSM COMERCIO DE TINTAS LTDA';
$pregao_1_itens_1->qtd_minima = '0';
$pregao_1_itens_1->natureza_despesa = '33.90.30';
pr($pregao_1_itens_1);
$pregao_item_store->update($pregao_1_itens_1);

$pregao_1_itens_2 = new PregaoItemDomain();
$pregao_1_itens_2->_id = ++$id;
$pregao_1_itens_2->pregao_id = 1;
$pregao_1_itens_2->cod_item_pregao = 15;
$pregao_1_itens_2->nome = "Massa corrida";
$pregao_1_itens_2->descricao = "Massa corrida, tempo secagem: 4 h, composição básica: emulsão acrílica estirenada, hidrocarbonetos alifá, solubilidade: água";
$pregao_1_itens_2->valor_unitario = 47.00;
$pregao_1_itens_2->valor_solicitado = 11515.00;
$pregao_1_itens_2->qtd_total = 275;
$pregao_1_itens_2->qtd_disponivel = 30;
$pregao_1_itens_2->qtd_solicitada = 245;
$pregao_1_itens_2->unidade = "Kg";
$pregao_1_itens_2->fornecedor = '28.040.796/0001-25 - SSM COMERCIO DE TINTAS LTDA';
$pregao_1_itens_2->qtd_minima = '0';
$pregao_1_itens_2->natureza_despesa = '33.90.30';
pr($pregao_1_itens_2);
$pregao_item_store->update($pregao_1_itens_2);

$pregao_2_itens_1 = new PregaoItemDomain();
$pregao_2_itens_1->_id = ++$id;
$pregao_2_itens_1->pregao_id = 2;
$pregao_2_itens_1->cod_item_pregao = 1;
$pregao_2_itens_1->nome = "Ar condicionado central";
$pregao_2_itens_1->descricao = "Splitão a ar remoto com descarga axial 15 tr 380v – 3f – 60 hz  CXPA15 (Trane) ou similar";
$pregao_2_itens_1->valor_unitario = 40000.00;
$pregao_2_itens_1->valor_solicitado = 40000.00;
$pregao_2_itens_1->qtd_total = 3;
$pregao_2_itens_1->qtd_disponivel = 1;
$pregao_2_itens_1->qtd_solicitada = 3;
$pregao_2_itens_1->unidade = "UN";
$pregao_2_itens_1->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_1->qtd_minima = '0';
$pregao_2_itens_1->natureza_despesa = '44.90.52';



pr($pregao_2_itens_1);
$pregao_item_store->update($pregao_2_itens_1);

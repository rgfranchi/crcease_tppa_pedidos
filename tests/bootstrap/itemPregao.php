<?php

$item_pregao_delete = new BasicStore('ItemPregaoStore','ItemPregao');
$item_pregao_delete->getStore()->deleteStore();

$item_pregao_store = new BasicStore('ItemPregaoStore','ItemPregao');
$id = 0;

$pregao_1_itens_1 = new ItemPregaoDomain();
$pregao_1_itens_1->_id = ++$id;
$pregao_1_itens_1->pregao_id = 1;
$pregao_1_itens_1->cod_item_pregao = 1;
// $pregao_1_itens_1->nome = "Tinta acrílica";
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
$item_pregao_store->create_update_object((array) $pregao_1_itens_1);

$pregao_1_itens_2 = new ItemPregaoDomain();
$pregao_1_itens_2->_id = ++$id;
$pregao_1_itens_2->pregao_id = 1;
$pregao_1_itens_2->cod_item_pregao = 15;
// $pregao_1_itens_2->nome = "Massa corrida";
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
$item_pregao_store->create_update_object((array) $pregao_1_itens_2);

$pregao_2_itens_1 = new ItemPregaoDomain();
$pregao_2_itens_1->_id = ++$id;
$pregao_2_itens_1->pregao_id = 2;
$pregao_2_itens_1->cod_item_pregao = 10;
// $pregao_2_itens_1->nome = "ITEM 1";
$pregao_2_itens_1->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_1->valor_unitario = 1000.00;
$pregao_2_itens_1->valor_solicitado = 0;
$pregao_2_itens_1->qtd_total = 150;
$pregao_2_itens_1->qtd_disponivel = 100;
$pregao_2_itens_1->qtd_solicitada = 50;
$pregao_2_itens_1->unidade = "UN";
$pregao_2_itens_1->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_1->qtd_minima = '0';
$pregao_2_itens_1->natureza_despesa = '44.90.52';
pr($pregao_2_itens_1);
$item_pregao_store->create_update_object((array) $pregao_2_itens_1);

$pregao_2_itens_2 = new ItemPregaoDomain();
$pregao_2_itens_2->_id = ++$id;
$pregao_2_itens_2->pregao_id = 2;
$pregao_2_itens_2->cod_item_pregao = 11;
// $pregao_2_itens_2->nome = "ITEM 2";
$pregao_2_itens_2->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_2->valor_unitario = 2000.00;
$pregao_2_itens_2->valor_solicitado = 0;
$pregao_2_itens_2->qtd_total = 300;
$pregao_2_itens_2->qtd_disponivel = 200;
$pregao_2_itens_2->qtd_solicitada = 100;
$pregao_2_itens_2->unidade = "UN";
$pregao_2_itens_2->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_2->qtd_minima = '0';
$pregao_2_itens_2->natureza_despesa = '44.90.52';
pr($pregao_2_itens_2);
$item_pregao_store->create_update_object((array) $pregao_2_itens_2);

$pregao_2_itens_3 = new ItemPregaoDomain();
$pregao_2_itens_3->_id = ++$id;
$pregao_2_itens_3->pregao_id = 2;
$pregao_2_itens_3->cod_item_pregao = 12;
// $pregao_2_itens_3->nome = "ITEM 3";
$pregao_2_itens_3->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_3->valor_unitario = 3000.00;
$pregao_2_itens_3->valor_solicitado = 0;
$pregao_2_itens_3->qtd_total = 320;
$pregao_2_itens_3->qtd_disponivel = 300;
$pregao_2_itens_3->qtd_solicitada = 20;
$pregao_2_itens_3->unidade = "UN";
$pregao_2_itens_3->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_3->qtd_minima = '0';
$pregao_2_itens_3->natureza_despesa = '44.90.52';
pr($pregao_2_itens_3);
$item_pregao_store->create_update_object((array) $pregao_2_itens_3);

$pregao_2_itens_4 = new ItemPregaoDomain();
$pregao_2_itens_4->_id = ++$id;
$pregao_2_itens_4->pregao_id = 2;
$pregao_2_itens_4->cod_item_pregao = 13;
// $pregao_2_itens_4->nome = "ITEM 4";
$pregao_2_itens_4->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_4->valor_unitario = 4000.00;
$pregao_2_itens_4->valor_solicitado = 0;
$pregao_2_itens_4->qtd_total = 600;
$pregao_2_itens_4->qtd_disponivel = 400;
$pregao_2_itens_4->qtd_solicitada = 200;
$pregao_2_itens_4->unidade = "UN";
$pregao_2_itens_4->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_4->qtd_minima = '0';
$pregao_2_itens_4->natureza_despesa = '44.90.52';
pr($pregao_2_itens_4);
$item_pregao_store->create_update_object((array) $pregao_2_itens_4);

$pregao_2_itens_5 = new ItemPregaoDomain();
$pregao_2_itens_5->_id = ++$id;
$pregao_2_itens_5->pregao_id = 2;
$pregao_2_itens_5->cod_item_pregao = 14;
// $pregao_2_itens_5->nome = "ITEM 5";
$pregao_2_itens_5->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_5->valor_unitario = 5000.00;
$pregao_2_itens_5->valor_solicitado = 0;
$pregao_2_itens_5->qtd_total = 750;
$pregao_2_itens_5->qtd_disponivel = 500;
$pregao_2_itens_5->qtd_solicitada = 250;
$pregao_2_itens_5->unidade = "UN";
$pregao_2_itens_5->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_5->qtd_minima = '0';
$pregao_2_itens_5->natureza_despesa = '44.90.52';
pr($pregao_2_itens_5);
$item_pregao_store->create_update_object((array) $pregao_2_itens_5);

$pregao_2_itens_6 = new ItemPregaoDomain();
$pregao_2_itens_6->_id = ++$id;
$pregao_2_itens_6->pregao_id = 2;
$pregao_2_itens_6->cod_item_pregao = 15;
// $pregao_2_itens_6->nome = "ITEM 6";
$pregao_2_itens_6->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_6->valor_unitario = 6000.00;
$pregao_2_itens_6->valor_solicitado = 0;
$pregao_2_itens_6->qtd_total = 900;
$pregao_2_itens_6->qtd_disponivel = 600;
$pregao_2_itens_6->qtd_solicitada = 300;
$pregao_2_itens_6->unidade = "UN";
$pregao_2_itens_6->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_6->qtd_minima = '0';
$pregao_2_itens_6->natureza_despesa = '44.90.52';
pr($pregao_2_itens_6);
$item_pregao_store->create_update_object((array) $pregao_2_itens_6);

$pregao_2_itens_7 = new ItemPregaoDomain();
$pregao_2_itens_7->_id = ++$id;
$pregao_2_itens_7->pregao_id = 2;
$pregao_2_itens_7->cod_item_pregao = 16;
// $pregao_2_itens_7->nome = "ITEM 7";
$pregao_2_itens_7->descricao = "Lorem ipsum dolor sit amet. Sit corrupti quibusdam est fuga assumenda ut veniam expedita At enim provident. Quo nulla consequuntur aut cumque quas qui consequuntur numquam. Qui repudiandae quos vel nihil obcaecati non esse possimus eos incidunt molestiae eos quis ducimus.";
$pregao_2_itens_7->valor_unitario = 7000.00;
$pregao_2_itens_7->valor_solicitado = 0;
$pregao_2_itens_7->qtd_total = 950;
$pregao_2_itens_7->qtd_disponivel = 700;
$pregao_2_itens_7->qtd_solicitada = 350;
$pregao_2_itens_7->unidade = "UN";
$pregao_2_itens_7->fornecedor = '04.622.501/0001-60 - ENGECLIMA DO BRASIL COMERCIO E SERVICOS DE REFRIGERACAO';
$pregao_2_itens_7->qtd_minima = '0';
$pregao_2_itens_7->natureza_despesa = '44.90.52';
pr($pregao_2_itens_7);
$item_pregao_store->create_update_object((array) $pregao_2_itens_7);

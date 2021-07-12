<?php

// include '../stores/BasicStore.php';
include '../domain/Pregoes.php';

$is_test = true;

// $config_test = config_test();
include 'PregaoController.php';

pr("--------- TESTE CONTROLLER DE " . __FILE__ . " --------- ");

$test = new PregaoController();
// pr($test);

// $test->index();

$test->add();

$testPregoes = new Pregoes();
$testPregoes->nome = "85/CONTROLLER/2020";
$testPregoes->objeto = "Aquisição com instalação de Ar condicionado para o CRCEA-SE.";
$testPregoes->valor_total = '100.000,00';
$testPregoes->valor_solicitado = '20.000,00';
$testPregoes->qtd_solicitada = 180;
$testPregoes->qtd_disponivel = 820;

// $test->save($testPregoes);



$stores = new PregaoStore();
$stores->getStore()->deleteStore();

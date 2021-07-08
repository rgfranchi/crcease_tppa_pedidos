<?php

$is_test = true; 

// $config_test = config_test();
include 'PregaoStore.php';
include '../domain/Pregoes.php';

$test = new PregaoStore();

$testPregoes = new Pregoes();
$testPregoes->nome = "85/GAP/2020";
$testPregoes->objeto = "Aquisição com instalação de Ar condicionado para o CRCEA-SE.";
$testPregoes->valor_total = '100.000,00';
$testPregoes->valor_solicitado = '20.000,00';
$testPregoes->qtd_solicitada = 180;
$testPregoes->qtd_disponivel = 820;

pr($test->create($testPregoes));
pr("FIND");
$pregao = $test->read(1);
pr($pregao);
// atualiza
$pregao['nome'] = "99/UPDATE/2020";
pr($test->update($pregao));
// busca todos;
pr($test->findAll());
// exclui
pr($pregao);
pr($test->delete($pregao['_id']));
// busca todos;
pr($test->findAll());
$test->getStore()->deleteStore();

?>
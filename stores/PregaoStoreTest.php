<?php

$is_test = true;

// $config_test = config_test();
include '../config.php';
include 'PregaoStore.php';
include '../domain/Pregoes.php';


pr("--------- TESTE CRUD DE " . __FILE__ . " --------- ");

$test = new PregaoStore();

$testPregoes = new Pregoes();
$testPregoes->nome = "85/GAP/2020";
$testPregoes->objeto = "Aquisição com instalação de Ar condicionado para o CRCEA-SE.";
$testPregoes->valor_total = '100.000,00';
$testPregoes->valor_solicitado = '20.000,00';
$testPregoes->qtd_solicitada = 180;
$testPregoes->qtd_disponivel = 820;

$create = $test->create($testPregoes);
pr($create);
if ($create['nome'] != $testPregoes->nome) {
    throw new Exception("Falha ao salvar registro");
}

$read = $test->read(1);
pr($read);
if ($read['nome'] != $testPregoes->nome) {
    throw new Exception("Falha ao ler registro");
}

// atualiza
$testPregoes->_id = $read['_id'];
$testPregoes->nome = "99/UPDATE/2020";
$update = $test->update($testPregoes);
pr($update);
if ($update['nome'] != $testPregoes->nome) {
    throw new Exception("Falha ao atualizar registro");
}

// busca todos
$findAll = $test->findAll();
pr($findAll);
if ($findAll[0]['nome'] != $testPregoes->nome) {
    throw new Exception("Falha ao buscar todos os registros");
}

// exclui
pr($test->delete(1));
$delete = $test->delete(1);
if ($delete != 1) {
    throw new Exception("Falha ao excluir registro");
}

$test->getStore()->deleteStore();

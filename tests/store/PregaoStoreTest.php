<?php

$is_test = true;

// $config_test = config_test();
include '../test_config.php';
include $app_path . '/store/PregaoStore.php';
// include '../domain/Pregoes.php';


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
if ($create->nome != $testPregoes->nome) {
    throw new Exception("Falha ao SALVAR registro");
}

$read = $test->findById(1);
pr($read);
if ($read->nome != $testPregoes->nome) {
    throw new Exception("Falha ao LER registro");
}

// atualiza
$testPregoes->_id = $read->_id;
$testPregoes->nome = "99/UPDATE/2020";
$update = $test->update($testPregoes);
pr($update);
if ($update->nome != $testPregoes->nome) {
    throw new Exception("Falha ao ATUALIZAR registro");
}

// busca todos
$findAll = $test->findAll();
pr($findAll);
if ($findAll[0]->nome != $testPregoes->nome) {
    throw new Exception("Falha ao BUSCAR TODOS os registros");
}

// exclui
pr($test->delete(1));
$delete = $test->delete(1);
if ($delete != 1) {
    throw new Exception("Falha ao EXCLUIR registro");
}

// save
$save = $test->save($testPregoes);
pr($save);
if ($save->nome != $testPregoes->nome) {
    throw new Exception("Falha ao SALVAR registro");
}

$test->getStore()->deleteStore();

<?
$app_path = str_replace('tests/bootstrap', "", __DIR__);

include_once $app_path . '/config.php';

echo '<h1>INCLUI VALORES NO BANCO DE DADOS PARA TESTES</h1>';

include 'pregoes.php';
include 'pregaoItens.php';

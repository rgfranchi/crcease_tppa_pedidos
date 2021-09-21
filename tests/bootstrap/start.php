<?php
$app_path = str_replace('tests' . DIRECTORY_SEPARATOR . 'bootstrap', "", __DIR__);

include_once $app_path . '/config.php';

include_once $app_path . '/store/BasicStore.php';

echo '<h1>INCLUI VALORES NO BANCO DE DADOS PARA TESTES</h1>';

include 'pregao.php';
include 'pregaoItem.php';
include 'pedidoPregao.php';

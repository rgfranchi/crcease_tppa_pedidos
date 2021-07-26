<?php

$app_path = str_replace('tests', "", __DIR__);

include_once $app_path . 'config.php';

$config_store["path_store"] = __DIR__ . "/TEST_TPPA_STORE";

pr($config_store);

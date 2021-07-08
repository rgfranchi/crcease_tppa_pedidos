<?php

$config_store = array(
    "path_store" => __DIR__."/TPPA_STORE"
);

if(isset($is_test) && $is_test) {
    $config_store["path_store"] = __DIR__."/TEST_TPPA_STORE";
}


define('CONFIG', array('config_store' => $config_store));

/**
 * Exibe variável na tela (Debug)
 * @param type $var -> a ser exibida;
 */
function pr($var, $die = false) {
    $trace = debug_backtrace();
    echo "<pre>--- DEBUG --- " . $trace[0]['file'] . "(" . $trace[0]['line'] . ")</br>";
    print_r($var);
    echo "</pre>";
    $die ? die() : '';
}
?>
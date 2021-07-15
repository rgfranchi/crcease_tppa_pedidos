<?php


define('__ROOT__', dirname(__FILE__));

/**
 * Configuração padrão do index.
 */
$config_index = array(
    "default_controller" => "Pregao",
    "default_action" => "index",
);

/**
 * Configurações do armazenamento das informações.
 */
$config_store = array(
    "path_store" => __DIR__ . "/TPPA_STORE"
);

if (isset($is_test) && $is_test) {
    $config_store["path_store"] = __DIR__ . "/TEST_TPPA_STORE";
}


define('CONFIG', array('config_store' => $config_store));


function urlController($controller, $function, $param = array())
{
    $param['controller'] = $controller;
    $param['action'] = $function;
    return "index.php?" . http_build_query($param);
}

function camelToSnakeCase($string)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
}

function snakeToCamelCase($string)
{
    return str_replace('_', '', ucwords($string, '_'));
}


/**
 * Exibe variável na tela (Debug)
 * @param type $var -> a ser exibida;
 */
function pr($var, $die = false)
{
    $trace = debug_backtrace();
    echo "<pre>--- DEBUG --- " . $trace[0]['file'] . "(" . $trace[0]['line'] . ")</br>";
    print_r($var);
    echo "</pre>";
    $die ? die() : '';
}

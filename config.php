<?php
setlocale(LC_ALL, 'pt_BR');

include "BasicSystem.php";
include "BasicRawObject.php";

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


function snakeToTextCase($string)
{
    return str_replace('_', ' ', ucwords($string, '_'));
}

/**
 * Retira ',' do valor para conversão em float.
 */
function convertCommaToDot($value) {
    if(empty($value)) {
        $value = 0;
    }
    if(is_numeric($value)) {
        return number_format($value, 2,'.','');
    }
    $value = str_replace(',','_',$value);
    $value = str_replace('.','_',$value);
    if(empty($value)) {
        return 0;
    }
    $pos = strrpos($value, '_');
    if($pos !== false) {
        $value = substr_replace($value, '.', $pos, strlen("_"));
        $value = str_replace('_','',$value);
    }
    if(is_numeric($value)) {
        return number_format($value, 2,'.','');
    } else {
        throw new Exception(sprintf("Não foi possível converter o valor '%s' em numero",$value));
    }
}

/**
 * Retira ',' do valor para conversão em float.
 */
function convertToMoneyBR($value) {
    $value = empty($value) ? 0.00 : $value;
    return number_format($value, 2,',','.');
}

/**
 * Convert to date time BR
 */
function convertToDateTimeBR($value, $time = true) {
    if(empty($value)) {
        return null;
    }    
    $dateTime = new DateTime($value);
    $mask = 'd/m/Y';
    $mask .= $time ? ' H:i:s' : '';
    return $dateTime->format($mask);
}

/**
 * Convert to date time BR
 */
function convertToDateTimeSystem($value, $time = true) {
    if(empty($value)) {
        return null;
    }
    $dateTime = str_replace('/', '-', $value); // considera '-' formato Europeu de data.
    $mask = 'Y-m-d';
    $mask .= $time ? ' H:i:s' : '';
    return date($mask, strtotime($dateTime));
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


function loadException($textException) {
    $trace = debug_backtrace();
    foreach($trace as $key => $value) {
        echo "[" . $key . "]" . $value['file'] . "(" . $value['line'] . ")-".$value['function']."</br>";
    }
    throw new Exception($textException);
}


function navbarActive($active = false)
{
    return $active ? 'active' : '';
}

<?php 
/**
 * Funções básicas do sistema.
 */

 /**
 * Controla permissão de acesso.
 */
function permission($controller, $action) {
    $permissions = CONFIG['PERMISSION'];
    $isPermission = false;
    if(isset($permissions['*'])) {
        return $permissions['*'];
    }
    if(!isset($permissions[$controller])) {
        return null;
    }    
    if(isset($permissions[$controller]['*'])) {
        $isPermission = $permissions[$controller]['*'];
    } 
    if(isset($permissions[$controller][$action])) {
        $isPermission = $permissions[$controller][$action];
    }
    return $isPermission;
}

/**
 * Constroi url para acesso ao sistema.<br>
 * Verifica se possui acesso, se não retorna nulo.<br> 
 * @param string $controller nome do controle (Classe da pasta controller finalizada com Controller)
 * @param string $action função pertencente controle.
 * @param string $param parâmetros da url.
 * 
 */
function urlController($controller, $action, $param = array())
{
    if(permission($controller,$action)) {
        $param['controller'] = $controller;
        $param['action'] = $action;
        return "index.php?" . http_build_query($param);
    } else {
        return null;
    }
}

/**
 * Converte Texto.
 * Ex: IssoEUmTexto para isso_e_um_texto
 */
function camelToSnakeCase($string)
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
}

/**
 * Converte Texto.
 * Ex: isso_e_um_texto para IssoEUmTexto
 */
function snakeToCamelCase($string)
{
    return str_replace('_', '', ucwords($string, '_'));
}


/**
 * Converte Texto.
 * Ex: isso_e_um_texto para Isso E Um Texto
 */
function snakeToTextCase($string)
{
    return str_replace('_', ' ', ucwords($string, '_'));
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

/**
 * Carrega exceções no sistema
 * @todo redirecionar para página de erro.
 */
function loadException($textException) {
    $trace = debug_backtrace();
    foreach($trace as $key => $value) {
        echo "[" . $key . "]" . $value['file'] . "(" . $value['line'] . ")-".$value['function']."</br>";
    }
    throw new Exception($textException);
}

/**
 * Mantem na seção o valor de ativo ou não da NAVBAR.
 */
function navbarActive($active = false)
{
    return $active ? 'active' : '';
}
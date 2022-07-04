<?php 
namespace TPPA\CORE;

use Exception;
use DateTime;

/**
 * Funções básicas do sistema.
 */
class BasicFunctions {
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
     * Constrói url para acesso ao sistema.<br>
     * Verifica se possui acesso, se não retorna nulo.<br> 
     * @param string $controller nome do controle (Classe da pasta controller finalizada com Controller)
     * @param string $action função pertencente controle.
     * @param string $param parâmetros da url.
     * 
     */
    function urlController($controller, $action, $param = array())
    {
        if($this->permission($controller,$action)) {
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
     * Mantém na seção o valor de ativo ou não da NAVBAR.
     */
    function navbarActive($active = false)
    {
        return $active ? 'active' : '';
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
            $this->loadException(sprintf("Não foi possível converter o valor '%s' em numero",$value));
        }
    }

    /**
     * Retira ',' do valor para conversão em float.
     */
    function convertToMoneyBR($value) {
        $value = empty($value) ? 0.00 : $value;
        if(!is_numeric($value)) {
            return $value;
        }
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
}
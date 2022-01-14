<?php
namespace TPPA;

session_start();
setlocale(LC_ALL, 'pt_BR');

/**
 *  realiza operação include para funções quando declaradas.<br>
 *  Baseado no código PhpSpreedsheet de vendors.
 **/ 
include "./core/autoloader.php";
include "./core/basic.php";
include "config.php";
use Exception;
$basicFunctions = new CORE\BasicFunctions();

$params = $_GET;
$home_page = CONFIG['HOME_PAGE'];
if (!isset($params['controller'])) {
    $params['controller'] = $home_page['controller'];
    $params['action'] = $home_page['action'];
}

// direciona para controller e ação (metodo).
try {
    $params['controller'] = str_replace(array("'", "\"", "&quot;"), '', $params['controller']);
    $params['action'] = str_replace(array("'", "\"", "&quot;"), '', $params['action']);

    if($basicFunctions->permission($params['controller'], $params['action']) === false) {
        $params['controller'] = $home_page['controller'];
        $params['action'] = $home_page['action'];
    } 

    $className = $params['controller'] . "Controller";

    
    $pathController = "./app/controller/" . $className . ".php";
    if (!file_exists($pathController)) {
        $basicFunctions->loadException('Falha ao carregar Controller [' . $pathController . ']');
    }
    $useClassName =  'TPPA\\APP\\controller\\'.$className;
    $controller = new $useClassName;
    
    // include $pathController;
    
    // $controller = new $className();
    $action = $params['action'];
    
    if (!method_exists($controller, $action)) {
        $basicFunctions->loadException('Falha ao carregar Ação (Método) [' . $pathController . '][' . $action . ']');
    }
    $controller->{$action}($params);

   
} catch (Exception $e) {
    echo '<h1>' . $e->getMessage() . '</h1>';
}
// navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled
// navbar-nav bg-gradient-primary sidebar sidebar-dark accordion



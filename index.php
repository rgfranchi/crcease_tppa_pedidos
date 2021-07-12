<?php

include 'config.php';

$params = $_GET;
if (!isset($params['controller'])) {
    $params['controller'] = $config_index['default_controller'];
    $params['action'] = $config_index['default_action'];
}

// direciona para controller e ação (metodo).
try {
    $params['controller'] = str_replace(array("'", "\"", "&quot;"), '', $params['controller']);
    $params['action'] = str_replace(array("'", "\"", "&quot;"), '', $params['action']);

    $className =  $params['controller'] . "Controller";
    // $className = 'PregaoController';
    $pathController = "./controller/" . $className . ".php";
    if (!file_exists($pathController)) {
        throw new Exception('Falha ao carregar Controller [' . $pathController . ']');
    }
    include $pathController;
    $controller = new $className();
    $action = $params['action'];
    if (!method_exists($controller, $action)) {
        throw new Exception('Falha ao carregar Ação (Método) [' . $pathController . '][' . $action . ']');
    }
    $controller->{$action}($params);
} catch (Exception $e) {
    echo '<h1>' . $e->getMessage() . '</h1>';
}

<?php
// pasta raiz da aplicação.

use function TPPA\logger\pr;

define('__ROOT__', dirname(__FILE__));
define('__APP_VIEW__', __ROOT__.'/app/view');
define('__APP_VENDOR__', __ROOT__.'/app/vendor');

/**
 * array('<nome controller>' => array('<nome action>' = <acesso true ou false>))
 * Se '*' acessa toda arvore.
 */
$config_permission = array(
    "Session" => array("*" => true),
    "Dashboard" => array(
        "index" => true
    ),
    "Exception" => array(
        "access_denied" => true
    ),
    // "PedidoPregao" => array(
    //     "*" => true,
    //     // "index" => true,
    //     // "find" => true,
    //     "edit_solicitado" => false,
    //     "edit_aprovado" => false,
    //     "delete" => false,
    // ),
    "PedidoPregaoPesquisar" => array(
        "*" => true,
    ),    
    "User" => array(
        'add_lpad' => true, 
        'add_externo' => true,
        'save_externo' => true,
    )
);

if(isset($_SESSION['login'])) {
    if(isset($_SESSION['login']['admin']) && $_SESSION['login']['admin'] == true) {
        $config_permission["*"] = true;
    }
    if(isset($_SESSION['login']['gerente']) && $_SESSION['login']['gerente'] == true) {
        $config_permission["PedidoPregao"]["edit_solicitado"] = true;
    }
    if(isset($_SESSION['login']['create_user']) && $_SESSION['login']['create_user'] == true) {
        $config_permission['User']['save_lpad'] = true;
    }
    if(isset($_SESSION['login']['basico']) && $_SESSION['login']['basico'] == true) {
        $config_permission['PedidoPregao'] = array(
            "*" => true,
            // "index" => true,
            // "find" => true,
            "edit_solicitado" => false,
            "edit_aprovado" => false,
            "delete" => false,
        );
        $config_permission['User'] = array(
            'my_info' => true, 
            'update' => true
        );
    }
}

define('TMP_FOLDER', 'tmp');

$database_path = "../DATABASE_TPPA/DESENVOLVIMENTO";
// print '<pre>';
// var_dump($_SERVER);
// var_dump($_SERVER['SCRIPT_FILENAME']);
// print '</pre>';

if(strpos($_SERVER['SCRIPT_FILENAME'], "HOMOLOGA") !== false) {
    $database_path = "../DATABASE_TPPA/HOMOLOGA";
}
if(strpos($_SERVER['SCRIPT_FILENAME'], "PRODUCAO") !== false) {
    $database_path = "../DATABASE_TPPA/PRODUCAO";
}

// Variáveis de configuração do sistema.
define('CONFIG', 
    array(
        'PERMISSION' => $config_permission,
        'STORE' => array(
            "path_store" => $database_path
        ),         
        'HOME_PAGE' => array(
                "controller" => "Dashboard",
                "action" => "index",
            )
        )
);


// var_dump(CONFIG);

// configuração para acesso a rede de usuário do CRCEASE
function lpad_config() {
    return array(
        'server' => "crcease.intraer",
        'port' => "389",
        'domain' => "@crcease.intraer" 
    );
}

/**
 * Setores que são atendidos pelo sistema.
 */
function setores() {
    return array( // setores que devem ser considerados pelo sistema.
        'DTCEA-SP',
        'DTCEA-MT',
        'DTCEA-SJ',
        'DTCEA-GW',
        'DTCEA-AF',
        'DTCEA-GL',
        'DTCEA-ST',
		'DTCEA-SC',
		'DA',
		'DO',
        'DT',
        'CTR',
		'TCAQ',
		'TCEM', 
        'ELM',
		'TECL',
		'TEEL',
		'TEES',
		'TEMC',
        'LSC',
		'NAV',
		'TNAV',
		'TNMT',
        'PLT',
		'TPMC',
		'TPPA',
        'RAD',
		'TREE',
		'TRMR',
        'STI',
		'TIAD',
		'TIMC',
		'TIOP',
		'TISI',
        'SUP',
		'TSAC',
		'TSAR',
		'TSES',
		'TSRE',
        'TEL',
		'TTEN',
		'TIIR',
		'TTRC',
		'TTSA',
		'TTST',
		'TTTF',
    );
}

function grupos() {
    return array( // setores que devem ser considerados pelo sistema.
        'BASICO' => "BÁSICO",
        'ADMIN' => "ADMINISTRADOR",
        'GERENTE' => "GERENTE",
    );
}
<?php


include "BasicSystem.php";
include "BasicRawObject.php";

define('__ROOT__', dirname(__FILE__));

/**
 * Configurações do armazenamento das informações.
 */
// $config_store = array(
//     "path_store" => __DIR__ . "/TPPA_STORE"
// );

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
    "PedidoPregao" => array(
        "*" => true,
        // "index" => true,
        // "find" => true,
        "edit_solicitado" => false,
        "edit_aprovado" => false,
    ),
);

if(isset($_SESSION['login'])) {
    if(isset($_SESSION['login']['admin']) && $_SESSION['login']['admin'] == true) {
        $config_permission["*"] = true;
    }
}


define('TMP_FOLDER', 'tmp');

define('CONFIG', 
    array(
        'PERMISSION' => $config_permission,
        'STORE' => array(
            "path_store" => __DIR__ . "/TPPA_STORE"
        ),         
        'HOME_PAGE' => array(
                "controller" => "Dashboard",
                "action" => "index",
            )
        )
);

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
        loadException(sprintf("Não foi possível converter o valor '%s' em numero",$value));
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

include "basicFunctions.php";

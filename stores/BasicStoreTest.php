<?php

$is_test = true;

// $config_test = config_test();
include '../config.php';
include 'BasicStore.php';
// include '../domain/Pregoes.php';


pr("--------- TESTE CRUD DE " . __FILE__ . " --------- ");

$teste = new BasicStore('store_teste', 'Pregoes');


$arrayToObject1 = array(
    array(
        'campo1' => 'valor1',
        'campo2' => 'valor2',
        'array1' => array(
            'sub_campo1' => 'sub_valor1',
            'sub_campo2' => 'sub_valor2',
            'sub_array1' => array(
                'sub_sub_campo1' => 'sub_sub_valor1',
                'sub_sub_campo2' => 'sub_sub_valor2',
            ),
        )
    ),
);

$obj1 = $teste->arrayToDomainObject($arrayToObject1);
pr($obj1);

$arrayToObject2 = array(
    array(
        'campo1' => 'valor1',
        'campo2' => 'valor2',
        'array1' => array(
            'sub_campo1' => 'valor1',
            'sub_campo2' => 'valor2',
            'sub_array1' => array(
                'sub_sub_campo1' => 'valor1',
                'sub_sub_campo2' => 'valor2',
            ),
        )
    ),
    array(
        'campoA' => 'valorA',
        'campoB' => 'valorB',
        'arrayA' => array(
            'sub_campoA' => 'sub_valorA',
            'sub_campoB' => 'sub_valorB',
            'sub_arrayA' => array(
                'sub_sub_campoA' => 'sub_sub_valorA',
                'sub_sub_campoB' => 'sub_sub_valorB',
            ),
        )
    ),
);
$obj2 = $teste->arrayToDomainObject($arrayToObject2);

pr($obj2);


$arrayToObject3 = array(
    array(
        'campo1' => 'valor1',
        'campo2' => 'valor2',
        'array1' => array(
            array(
                'sub_campo11' => 'valor1',
                'sub_campo21' => 'valor2',
                'sub_array11' => array(
                    'sub_sub_campo11' => 'valor1',
                    'sub_sub_campo21' => 'valor2',
                ),
            ),
            array(
                'sub_campo12' => 'valor1',
                'sub_campo22' => 'valor2',
                'sub_array12' => array(
                    'sub_sub_campo12' => 'valor1',
                    'sub_sub_campo22' => 'valor2',
                ),
            )
        )
    ),
    array(
        'campoA' => 'valorA',
        'campoB' => 'valorB',
        'arrayA' => array(
            'sub_campoA' => 'sub_valorA',
            'sub_campoB' => 'sub_valorB',
            'sub_arrayA' => array(
                'sub_sub_campoA' => 'sub_sub_valorA',
                'sub_sub_campoB' => 'sub_sub_valorB',
            ),
        )
    ),
    array(
        'campo1' => 'valor1',
        'campo2' => 'valor2',
        'array1' => array(
            array(
                'sub_campo11' => 'valor1',
                'sub_campo21' => 'valor2',
                'sub_array11' => array(
                    array(
                        'sub_sub_campo11' => 'valor1',
                        'sub_sub_campo21' => 'valor2',
                    )
                ),
            ),
            array(
                'sub_campo12' => 'valor1',
                'sub_campo22' => 'valor2',
                'sub_array12' => array(
                    array(
                        'sub_sub_campo121' => 'valor1',
                        'sub_sub_campo221' => 'valor2',
                    ),
                    array(
                        'sub_sub_campo122' => 'valor1',
                        'sub_sub_campo222' => 'valor2',
                    )
                ),
            )
        )
    ),
);
$obj3 = $teste->arrayToDomainObject($arrayToObject3);

pr($obj3);

$teste->getStore()->deleteStore();

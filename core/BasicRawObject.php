<?php

namespace TPPA\CORE;

interface BasicRawObject
{
    function getObject();
    function getObjectArray();
    function getFieldsName();

    /**
     * Aplicar validação de conversão do campo BasicSystem.arrayToObject.
     * @param $name nome do campo.
     * @param $value valor do campo.
     * @param &$newObject objeto com os valores enviados.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value);


    /**
     * Leitura dos campos utilizado no BasicSystem.arrayToObject;
     */
    function convertFieldRead($name, $value, &$newObject);
}
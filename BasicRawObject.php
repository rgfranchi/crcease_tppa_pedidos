<?php

interface BasicRawObject
{
    function getObject();
    function getObjectArray();
    function getFieldsName();
    /**
     * Aplicar para classe instanciada a conversão do campo.
     * @param $name nome do campo.
     * @param $value valor do campo.
     * @param &$newObject objeto com os valores enviados.
     */
    function convertField($name, $value, &$newObject);
    /**
     * Aplicar validação de conversão do campo.
     * @param $name nome do campo.
     * @param $value valor do campo.
     * @param &$newObject objeto com os valores enviados.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value);
}
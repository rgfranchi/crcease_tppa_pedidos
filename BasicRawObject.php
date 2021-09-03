<?php

interface BasicRawObject
{
    function getObject();
    function getObjectArray();
    function getFieldsName();
    /**
     * Aplicar para classe instanciada a conversão do campo.
     */
    function convertField($name, $value);
    /**
     * Aplicar validação de conversão do campo.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value);
}
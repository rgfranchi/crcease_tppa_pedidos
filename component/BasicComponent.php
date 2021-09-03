<?php

class BasicComponent implements BasicRawObject
{
    function getObject()
    {
        return $this;
    }
    function getObjectArray()
    {
        return (array) $this;
    }
    function getFieldsName() 
    {
        return array_keys((array) $this);
    }
    /**
     * Aplicar para classe instanciada a conversão do campo.
     */
    function convertField($name, $value) {
        return $value;
    }
    /**
     * Aplicar validação de conversão do campo.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value) {
        return true;
    }    
}
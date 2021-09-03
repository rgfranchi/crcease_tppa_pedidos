<?php

class BasicDomain implements BasicRawObject
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

    /**
     * Converte apenas para criação do registro
     */
    function convertFieldCreate($name, $value) {
        return $value;
    }
    /**
     * Converte apenas para atualização registro
     */
    function convertFieldUpdate($name, $value) {
        return $value;
    }

    /**
     * Valida apenas para criação registro
     */    
    function validateFieldCreate($name, $value) {
        return true;
    }
    /**
     * Valida apenas para atualização registro
     */
    function validateFieldUpdate($name, $value) {
        return true;
    }

    /**
     * Verifica registro antes de excluir.
     * @return boolean | any se false exclui registro se não não exclui.
     */
    function beforeDelete($deleteId){
        return false;
    }

}

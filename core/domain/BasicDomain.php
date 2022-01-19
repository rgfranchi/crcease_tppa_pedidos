<?php
namespace TPPA\CORE\domain;
use TPPA\CORE\BasicRawObject;

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
     * Save 1.1 
     * Converte apenas para criação do registro
     */
    function convertFieldCreate($name, $value, &$newObject) {
        $newObject->{$name} = $value;
    }
    /**
     * Save 1.2
     * Converte apenas para atualização registro
     */
    function convertFieldUpdate($name, $value, &$newObject) {
        $newObject->{$name} = $value;
    }

    /**
     * Save 2.1
     * Valida apenas para criação registro
     */    
    function validateFieldCreate($name, $value) {
        return true;
    }
    /**
     * Save 2.2
     * Valida apenas para atualização registro
     */
    function validateFieldUpdate($name, $value) {
        return true;
    }

    /**
     * Save 3
     * Aplicar para classe instanciada a conversão do campo.
     */
    function convertField($name, $value, &$newObject) {
        $newObject->{$name} = $value;
    }
    /**
     * Save 3
     * Aplicar validação de conversão do campo.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value) {
        return true;
    }

    /**
     * Save 4 
     * Operação executada antes de salvar o array
     * 
     * @param $data array
     * @return $data.
     */
    function beforeSave($data) {
        return $data;
    }

    /**
     * Delete 1
     * Verifica registro antes de excluir.
     * @return boolean | any se false exclui registro se não não exclui.
     */
    function beforeDelete($deleteId){
        return false;
    }
}

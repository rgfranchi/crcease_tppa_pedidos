<?php
namespace TPPA\CORE\domain;

use function TPPA\CORE\basic\pr;

class BasicDomain
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
     * Save 1 -> array com todos os campos
     * Operação executada antes de salvar o array
     * 
     * @param $data array
     * @return $data.
     */
    function beforeSave($data) {
        return $data;
    }


    /**
     * Save 1.1 -> array com todos os campos
     * Operação executada antes de criar
     * 
     * @param $data array
     * @return $data.
     */
    function beforeCreate($data) {
        return $data;
    }

    /**
     * Save 1.2 -> array com todos os campos
     * Operação executada antes de atualizar
     * 
     * @param $data array
     * @return $data.
     */
    function beforeUpdate($data) {
        return $data;
    }

    function validateSave($data) {
        return true;
    }

    function validateCreate($data) {
        return true;
    }

    function validateUpdate($data) {
        return true;
    }

    function validateDelete($data) {
        return true;
    }

    function afterRead($data) {
        return $data;
    }    

     /**
     * Delete 1
     * Verifica registro antes de excluir.
     * @return boolean (true) exclui registro.
     */
    function beforeDelete($data){
        return true;
    }

    // /**
    //  * Save 2.1 
    //  * Converte apenas para criação do registro
    //  */
    // function convertFieldCreate($name, $value, &$newObject) {
    //     $newObject->{$name} = $value;
    // }
    // /**
    //  * Save 2.2
    //  * Converte apenas para atualização registro
    //  */
    // function convertFieldUpdate($name, $value, &$newObject) {
    //     $newObject->{$name} = $value;
    // }

    // /**
    //  * Save 3.1
    //  * Valida apenas para criação registro
    //  */    
    // function validateFieldCreate($name, $value) {
    //     return true;
    // }
    // /**
    //  * Save 3.2
    //  * Valida apenas para atualização registro
    //  */
    // function validateFieldUpdate($name, $value) {
    //     return true;
    // }

    // /**
    //  * Save 4.1
    //  * Aplicar para classe instanciada a conversão do campo.
    //  * Ação salvar ou atualizar
    //  * Ação salvar.
    //  */
    // function convertFieldSave($name, $value, &$newObject) {
    //     $newObject->{$name} = $value;
    // }
    // /**
    //  * Save 4.2
    //  * Aplicar validação de conversão do campo.
    //  * @return boolean true (valido) false (invalido)
    //  */
    // function validateField($name, $value) {
    //     return true;
    // }

    // /**
    //  * Read 5
    //  * Aplicar para classe instanciada a conversão do campo.
    //  * Para leitura.
    //  */
    // function convertFieldRead($name, $value, &$newObject) {
    //     $newObject->{$name} = $value;
    // }


}


interface iBasicDomain {
    public function convertFieldCreate($name, $value, &$newObject);
    public function convertFieldUpdate($name, $value, &$newObject);
    public function validateFieldCreate($name, $value);
    public function validateFieldUpdate($name, $value);
    public function convertFieldRead($name, $value, &$newObject);
    public function validateFieldRead($name, $value);
    public function beforeSave($data);
    public function beforeDelete($deleteId);
}
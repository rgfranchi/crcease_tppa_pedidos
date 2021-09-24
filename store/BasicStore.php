<?php

require_once(__ROOT__ . '/config.php');
require_once(__ROOT__ . '/BasicSystem.php');
include_once(__ROOT__ . '/vendor/SleekDB/Store.php');

use SleekDB\Store;

/**
 * Operações CRUD e buscas padrões no banco de dados.
 */
class BasicStore extends BasicSystem
{
    protected $store = null;
    protected $domain = null;

    protected $domainName = null;

    /**
     * @param string nome da classe filha 
     * @param string domainName -> domínio do objeto 
     */
    function __construct($store_name, $domainName)
    {
        $config_store = CONFIG['config_store'];
        $this->store = new Store($store_name, $config_store["path_store"]);
        $this->domainName = $domainName;
        $this->domain = $this->loadDomain($domainName);
    }

    function create($array)
    {
        return $this->arrayToObject($this->store->insert($array), $this->domain);
    }
    function update($array)
    {
        $_id = $array['_id'];
        unset($array['_id']);
        return $this->arrayToObject($this->store->updateById($_id,$array), $this->domain);
    }
    function create_update_object($array)
    {
        return $this->arrayToObject($this->store->updateOrInsert($array), $this->domain);
    }


    /**
     * Cria ou atualiza Registro no banco de dados.<br>
     * Cria: '_id' zero ou menor.
     * Atualiza: '_id' maior que zero. 
     * Utiliza post em array.
     * @param Array (conforme utilizado no banco de dados).
     */
    function save($data)
    {
        $isNew = true;
        if (isset($data['_id'])) {
            if($data['_id'] > 0) { $isNew = false; }
            if($data['_id'] == 0) { unset($data['_id']); }
        } 

        $data = $this->domain->beforeSave($data);
        $saveObject = new $this->domain;
        foreach($data as $key => &$value) {
            if(!property_exists($saveObject,$key)) {
                loadException("Valor '$key' enviados não consta no objeto");
            }
            if($isNew) {
                $value = $saveObject->convertFieldCreate($key, $value);
                $saveObject->validateFieldCreate($key, $value);
            } else {
                $saveObject->{$key} = $saveObject->convertFieldUpdate($key, $value);
                $saveObject->validateFieldCreate($key, $saveObject->{$key});
            }
            $value = $saveObject->convertField($key, $value);
            $saveObject->validateField($key, $value);
        }
        // pr("SAVE END"); die;
        if ($isNew) {
            return $this->create($data);
        } else {
            return $this->update($data);
        }
    }

    // function saveAll($arrayObjects)
    // {
    //     if(!is_array($arrayObjects)) {
    //         loadException("Esperado array Array inválido.");
    //     }
    //     $ret = array();
    //     pr($ret);
    //     pr("VERIFICAR SE SERÁ ARRAY COM SUB ARRAY ou OBJETO");
    //     die;

    //     $toArray = $this->objectToArray($arrayObjects);
    //     foreach($toArray as $key => $values) {
    //         $ret[] = $this->save($values);
    //     }
    //     return $ret;
    // }

    /**
     * Busca por condição (conforme regras do Sleek DB)
     * @param $condition [field,param,value] ex.: ['nome', '==', 'James']
     * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findBy($condition, array $orderBy = null, int $limit = null, int $offset = null)
    {
        return $this->arrayToObject($this->store->findBy($condition, $orderBy, $limit, $offset), $this->domain);
    }
    function findById($id)
    {
        return $this->arrayToObject($this->store->findById($id), $this->domain);
    }
    /**
     * Excluir um registro.<br>
     * Verifica cada objeto antes de excluir.
     * @param int $limit
     * @return objeto excluido.
     */
    function delete($id)
    {
        $beforeDelete = $this->domain->beforeDelete($id);
        if($beforeDelete != false) {
            return $beforeDelete;
        }
        return $this->arrayToObject($this->store->deleteById($id), $this->domain);
    }
    
    /**
     * Busca todos os registros. (conforme regras do Sleek DB)
     * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findAll(array $orderBy = null, int $limit = null, int $offset = null)
    {
        return $this->arrayToObject($this->store->findAll($orderBy, $limit, $offset), $this->domain);
    }
    function emptyValues()
    {
        return $this->domain;
    }

    /** 
     * Elimina campos do domínio não utilizado no componente.
     */
    function loadObject($newObject) {
        $this->domain = $newObject;
    }

    function getStore()
    {
        return $this->store;
    }
}

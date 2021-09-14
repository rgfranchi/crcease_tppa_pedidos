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
    protected $object = null;

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
        $this->object = $this->loadDomain($domainName);
    }

    function create($array)
    {
        return $this->arrayToObject($this->store->insert($array), $this->object);
    }
    function update($array)
    {
        return $this->arrayToObject($this->store->updateOrInsert($array), $this->object);
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
        $saveObject = new $this->object;
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
        if ($isNew) {
            return $this->create($data);
        } else {
            return $this->update($data);
        }
    }

    /**
     * Verifica se o array enviado tem os mesmos parâmetros da data enviada.
     */
    // function validateData($data) {

    //     $this->object;


    //     $copyData = (array) $data;
    //     $newObject = new $this->object;
    //     foreach(array_keys(get_object_vars($this->object)) as $key) {
    //         $newObject->$key = $copyData[$key];
    //         unset($copyData[$key]);
    //     }
    //     if(!empty($copyData)){
    //         pr($this->object);
    //         pr($copyData);
    //         throw new Exception("Valores enviados para salvar incompatível com objeto previsto");
    //         return false;
    //     }
    //     return $newObject;
    // }

    function saveAll($arrayObjects)
    {
        if(!is_array($arrayObjects)) {
            loadException("Esperado array Array inválido.");
        }
        $ret = array();
        pr($ret);
        pr("VERIFICAR SE SERÁ ARRAY COM SUB ARRAY ou OBJETO");
        die;

        $toArray = $this->objectToArray($arrayObjects);
        foreach($toArray as $key => $values) {
            $ret[] = $this->save($values);
        }
        return $ret;
    }

    /**
     * Busca por condição (conforme regras do Sleek DB)
     * @param $condition [field,param,value] ex.: ['nome', '==', 'James']
     * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findBy($condition, array $orderBy = null, int $limit = null, int $offset = null)
    {
        return $this->arrayToObject($this->store->findBy($condition, $orderBy, $limit, $offset), $this->object);
    }
    function findById($id)
    {
        return $this->arrayToObject($this->store->findById($id), $this->object);
    }
    function delete($id)
    {
        $beforeDelete = $this->object->beforeDelete($id);
        if($beforeDelete != false) {
            return $beforeDelete;
        }
        return $this->arrayToObject($this->store->deleteById($id), $this->object);
    }
    /**
     * Busca todos os registros. (conforme regras do Sleek DB)
     * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findAll(array $orderBy = null, int $limit = null, int $offset = null)
    {
        return $this->arrayToObject($this->store->findAll($orderBy, $limit, $offset), $this->object);
    }
    function emptyValues()
    {
        return $this->object;
    }

    /** 
     * Elimina campos do domínio não utilizado no componente.
     */
    function loadObject($newObject) {
        $this->object = $newObject;
    }

    // function findById($id)
    // {
    //     return $this->arrayToDomainObject($this->store->findById($id));
    // }
    // function delete($id)
    // {
    //     return $this->arrayToDomainObject($this->store->deleteById($id));
    // }
    // function findAll()
    // {
    //     return $this->arrayToDomainObject($this->store->findAll());
    // }
    // function getStore()
    // {
    //     return $this->store;
    // }

    // /**
    //  * Converte Array em objeto.
    //  * @param array $array - array do banco de dados.
    //  * @param array $object - objeto para conversão.
    //  */
    // function arrayToDomainObject($array, $_object = null)
    // {
    //     if (!is_array($array)) {
    //         return $array;
    //     }
    //     $ret = array();
    //     // cria novo objeto para inserção na lista ou retorno.
    //     $newObject = empty($_object) ? new $this->object : new $_object;
    //     foreach ($array as $key => $value) {
    //         if (is_int($key)) {
    //             $ret[] = $this->arrayToDomainObject($value);
    //         } else {
    //             if(property_exists($newObject,$key)) {
    //                 $newObject->{$key} = $this->arrayToDomainObject($value);
    //             }
    //         }
    //     }
        
    //     if($this->object != $newObject) {
    //         // recebe configuração dos campos do objeto.
    //         $ret = $newObject->getObject();
    //     }
    //     return $ret;
    // }

    /**
     * Converte Objeto em array.
     * @todo Não testado objeto com sub-objeto.
     */
    // function domainObjectToArray($domain)
    // {
    //     if (!is_array($domain)) {
    //         return $domain->getObjectArray();
    //     }
    //     $ret = array();
    //     foreach ($domain as $key => $value) {
    //         if (is_int($key)) {
    //             $ret[] = $this->domainObjectToArray($value);
    //         } 
    //         // else {
    //         //     $ret = (array) $domain;
    //         //     foreach ($ret as $key => $value) {
    //         //         if (!is_array($domain)) {
    //         //             $ret[$key] = $this->domainObjectToArray($value);
    //         //         }
    //         //     }
    //         // }
    //     }

    //     return $ret;
    // }
}

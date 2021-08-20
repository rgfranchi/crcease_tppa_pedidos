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

    function create($object)
    {
        return $this->arrayToObject($this->store->insert((array) $object), $this->object);
    }
    function update($object)
    {
        return $this->arrayToObject($this->store->updateOrInsert((array) $object), $this->object);
    }

    /**
     * Salva array ou objeto após validação.<br>
     * Converte para array.
     * @param Objeto/Array sem _id insert com _id update.
     */
    function save($data)
    {
        $newObject = $this->validateData($data);
        if(!$newObject) {
            return false;
        }
        $dataArray = (array) $data;
        if (isset($dataArray['_id']) && $dataArray['_id'] > 0) {
            return $this->update($newObject->getObjectArray());
        } else {
            return $this->create($newObject->getObjectArray());
        }
    }

    /**
     * Verifica se o array enviado tem os mesmos parâmetros da data enviada.
     */
    function validateData($data) {
        $copyData = (array) $data;
        $newObject = new $this->object;
        foreach(array_keys(get_object_vars($this->object)) as $key) {
            $newObject->$key = $copyData[$key];
            unset($copyData[$key]);
        }
        if(!empty($copyData)){
            pr($this->object);
            pr($copyData);
            throw new Exception("Valores enviados para salvar incompatível com objeto previsto");
            return false;
        }
        return $newObject;
    }

    function saveAll($arrayObjects)
    {
        if(!is_array($arrayObjects)) {
            pr($arrayObjects);
            throw new Exception("Array inválido.");
            return false;
        }
        $ret = array();
        $toArray = $this->objectToArray($arrayObjects);
        foreach($toArray as $key => $values) {
            $ret[] = $this->save($values);
        }
        return $ret;
    }


    function findById($id)
    {
        return $this->arrayToObject($this->store->findById($id), $this->object);
    }
    function delete($id)
    {
        return $this->arrayToObject($this->store->deleteById($id), $this->object);
    }
    function findAll()
    {
        pr($this->store->findAll());

        return $this->arrayToObject($this->store->findAll(), $this->object);
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
    function getStore()
    {
        return $this->store;
    }

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

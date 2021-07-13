<?php

require_once(__ROOT__ . '/config.php');
include __ROOT__ . '/SleekDB/Store.php';

use SleekDB\Store;

/**
 * Operações CRUD e buscas padroes no banco de dados.
 */
class BasicStore
{
    private $store = null;
    private $object = null;
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct($store_name, $domainName = null)
    {
        $config_store = CONFIG['config_store'];
        $this->store = new Store($store_name, $config_store["path_store"]);

        if($domainName != null) {
            include __ROOT__. "/domain/" .$domainName.".php";
            $this->object = new $domainName();
        }
    }

    function create($object)
    {
        return $this->arrayToDomainObject($this->store->insert((array) $object));
    }
    function findById($id)
    {
        return $this->arrayToDomainObject($this->store->findById($id));
    }
    function update($object)
    {
        return $this->arrayToDomainObject($this->store->updateOrInsert((array) $object));
    }
    function delete($object_id)
    {
        return $this->arrayToDomainObject($this->store->deleteById($object_id));
    }
    function findAll()
    {
        return $this->arrayToDomainObject($this->store->findAll());
    }
    function getStore()
    {
        return $this->arrayToDomainObject($this->store);
    }

    function arrayToDomainObject($array)
    {
        if(!is_array($array)) {
            return $array;
        }
        if($this->object == null) {
            return $array;
        }
        foreach($array as $key => $value) {
            if(is_int($key)) {
                $ret[] = $this->arrayToDomainObject($value);
            } else {
                return $this->convertArrayToObject($array);
            }
        }
        return $ret;
    }

    function convertArrayToObject($array) {
        foreach ($array as $key => $value)
        {
            $this->object->$key = $value;
        }
        return $this->object;
    }

}

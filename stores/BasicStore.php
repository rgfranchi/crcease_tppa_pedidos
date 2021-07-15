<?php

require_once(__ROOT__ . '/config.php');
include_once(__ROOT__ . '/SleekDB/Store.php');

use SleekDB\Store;

/**
 * Operações CRUD e buscas padroes no banco de dados.
 */
class BasicStore
{
    private $store = null;
    private $object = null;
    // carrega objeto de relacionados.
    // protected $joinStore = array();


    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct($store_name, $domainName = null)
    {
        $config_store = CONFIG['config_store'];
        $this->store = new Store($store_name, $config_store["path_store"]);

        if ($domainName != null) {
            include __ROOT__ . "/domain/" . $domainName . ".php";
            $this->object = new $domainName();
        }
    }

    function create($object)
    {
        return $this->arrayToDomainObject($this->store->insert((array) $object));
    }
    function update($object)
    {
        return $this->arrayToDomainObject($this->store->updateOrInsert((array) $object));
    }

    function save($array)
    {
        $object = (object) $array;
        if (isset($object->_id) && $object->_id > 0) {
            return $this->update($object);
        } else {
            return $this->create($object);
        }
    }

    /**
     * Busca objetos relacionados 1 - N
     * @param string $mainId -> id do objeto.
     * @param object $joinStore -> N elementos a serem agrupado.
     * @param string $findField -> nome do campo de busca na store filha.
     */
    function joinToObjectById($mainId, $storeChildren, $findField)
    {
        $mainObject = $this->store->findById($mainId);
        $mainObject[camelToSnakeCase(get_class($storeChildren))] = $storeChildren->getStore()->createQueryBuilder()->where([$findField, "=", $mainId])->getQuery()->fetch();
        return $this->arrayToDomainObject($mainObject);
    }

    function findById($id)
    {
        return $this->arrayToDomainObject($this->store->findById($id));
    }
    function delete($id)
    {
        return $this->arrayToDomainObject($this->store->deleteById($id));
    }
    function findAll()
    {
        return $this->arrayToDomainObject($this->store->findAll());
    }
    function getStore()
    {
        return $this->store;
    }

    function arrayToDomainObject($array)
    {
        $ret = array();
        if (!is_array($array)) {
            return $array;
        }
        if ($this->object == null) {
            return $array;
        }

        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $ret[] = $this->arrayToDomainObject($value);
            } else {
                return (object) $array;
            }
        }
        return $ret;
    }
}

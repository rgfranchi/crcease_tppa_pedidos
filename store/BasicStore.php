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
        return $this->arrayToDomainObject($this->store->insert((array) $object));
    }
    function update($object)
    {
        return $this->arrayToDomainObject($this->store->updateOrInsert((array) $object));
    }

    /**
     * Objeto com _id executa update.
     * Objecto sem _id executa insert.
     */
    function save($object)
    {

        pr($this->domainObjectToArray($object));
        die;


        if (isset($object->_id) && $object->_id > 0) {
            return $this->update($object);
        } else {
            return $this->create($object);
        }
    }

    function saveAll($arrayObjects)
    {
        $toArray = $this->domainObjectToArray($arrayObjects);
        foreach ($toArray as &$value) {
            if (empty($value['_id'])) {
                unset($value["_id"]);
            }
        }
        return $this->arrayToDomainObject($this->store->updateOrInsertMany($toArray));
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

    /**
     * Converte Array em objeto.
     * @param array $array - array do banco de dados.
     * @param array $object - objeto para conversão.
     */
    function arrayToDomainObject($array, $_object = null)
    {
        if (!is_array($array)) {
            return $array;
        }
        $ret = array();
        // cria novo objeto para inserção na lista ou retorno.
        $newObject = empty($_object) ? new $this->object : new $_object;
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $ret[] = $this->arrayToDomainObject($value);
            } else {
                if(property_exists($newObject,$key)) {
                    $newObject->{$key} = $this->arrayToDomainObject($value);
                } 
            }
        }
        
        if($this->object != $newObject) {
            // recebe configuração dos campos do objeto.
            $ret = $newObject->getObject();
        }
        return $ret;
    }

    /**
     * Converte Objeto em array.
     * @todo Não testado objeto com sub-objeto.
     */
    function domainObjectToArray($domain)
    {

        if (!is_array($domain)) {
            return $domain->getObjectArray();
        }
        $ret = array();
        pr($domain);
        foreach ($domain as $key => $value) {
            if (is_int($key)) {
                $ret[] = $this->domainObjectToArray($value);
            } 
            // else {
            //     $ret = (array) $domain;
            //     foreach ($ret as $key => $value) {
            //         if (!is_array($domain)) {
            //             $ret[$key] = $this->domainObjectToArray($value);
            //         }
            //     }
            // }
        }

        return $ret;
    }
}

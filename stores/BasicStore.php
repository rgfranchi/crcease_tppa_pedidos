<?php

include "../config.php";
include '../SleekDB/Store.php';
use SleekDB\Store;

/**
 * Operações CRUD e buscas padroes no banco de dados.
 */
class BasicStore {
    private $store = null;

    /**
     * @param string nome da classe filha 
     */
    function __construct($store_name){
        $config_store = CONFIG['config_store'];
        $this->store = new Store($store_name, $config_store["path_store"]);
    }

    function create($object) {
        return $this->store->insert((array) $object);
    }
    function read($object_id) {
        return $this->store->findById($object_id);
    }
    function update($object) {
        return $this->store->updateOrInsert((array) $object);
    }
    function delete($object_id) {
        return $this->store->deleteById($object_id);
    }
    function findAll() {
        return $this->store->findAll();
    }    
    function getStore() {
        return $this->store;
    }

}
?>
<?php
namespace TPPA\CORE\store;
use TPPA\CORE\BasicSystem;

// importa SleekDB diretamente na classe
include __APP_VENDOR__.'/SleekDB/Store.php';
use SleekDB\Store;
use TPPA\CORE\BasicFunctions;

use function TPPA\CORE\basic\pr;

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
        $config_store = CONFIG['STORE'];
        $this->store = new Store($store_name, $config_store["path_store"]);
        $this->domainName = $domainName;
        $this->domain = $this->loadDomain($domainName);
        $this->basicFunctions = new BasicFunctions();
    }

    // function create($array)
    // {
    //     return $this->arrayToObject($this->store->insert($array), $this->domain);
    // }
    // function update($array)
    // {
    //     $_id = $array['_id'];
    //     unset($array['_id']);
    //     return $this->arrayToObject($this->store->updateById($_id,$array), $this->domain);
    // }
    // function create_update_object($array)
    // {
    //     return $this->arrayToObject($this->store->updateOrInsert($array), $this->domain);
    // }


    // /**
    //  * Cria ou atualiza Registro no banco de dados.<br>
    //  * Cria: '_id' zero ou menor.
    //  * Atualiza: '_id' maior que zero. 
    //  * Utiliza post em array.
    //  * @param Array (conforme utilizado no banco de dados).
    //  */
    // function save($data)
    // {
    //     $isNew = true;
    //     if (isset($data['_id'])) {
    //         if($data['_id'] > 0) { $isNew = false; }
    //         if($data['_id'] == 0) { unset($data['_id']); }
    //     } 
    //     // verificar todos os valores.
    //     $data = $this->domain->beforeSave($data);
    //     $newObject = new $this->domain;
    //     // verifica cada um dos campos.
    //     foreach($data as $key => &$value) {
    //         if(!property_exists($newObject,$key)) {
    //             unset($data[$key]);
    //             // $this->basicFunctions->loadException("Valor '$key' enviados não consta no objeto");
    //         }
    //         if($isNew) {
    //             $this->domain->convertFieldCreate($key, $value, $newObject);
    //             $this->domain->validateFieldCreate($key, $newObject->{$key});
    //         } else {
    //             $this->domain->convertFieldUpdate($key, $value, $newObject);
    //             $this->domain->validateFieldUpdate($key, $newObject->{$key});
    //         }
    //         $this->domain->convertFieldSave($key, $value, $newObject);
    //         $this->domain->validateField($key, $newObject->{$key});
    //         $value = $newObject->{$key};
    //     }
    //     if ($isNew) {
    //         return $this->create($data);
    //     } else {
    //         return $this->update($data);
    //     }
    // }

    // function saveAll($arrayObjects)
    // {
    //     if(!is_array($arrayObjects)) {
    //         $this->basicFunctions->loadException("Array inválido.");
    //     }
    //     foreach($arrayObjects as $key => $values) {
    //         $values = is_object($values) ? (array) $values : $values;
    //         $ret[$key] = $this->save($values);
    //     }
    //     return $ret;
    // }

    // /**
    //  * Busca por condição (conforme regras do Sleek DB)
    //  * @param $condition [field,param,value] ex.: ['nome', '==', 'James']
    //  * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
    //  * @param int $limit
    //  * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
    //  */
    // function findBy($condition, array $orderBy = null, int $limit = null, int $offset = null)
    // {
    //     return $this->arrayToObject($this->store->findBy($condition, $orderBy, $limit, $offset), $this->domain);
    // }
    // function findById($id)
    // {
    //     return $this->arrayToObject($this->store->findById($id), $this->domain);
    // }
    // /**
    //  * Excluir um registro.<br>
    //  * Verifica cada objeto antes de excluir.
    //  * @param int $limit
    //  * @return objeto excluído ou false se não excluir.
    //  */
    // function delete($id)
    // {
    //     $beforeDelete = $this->domain->beforeDelete($id);
    //     if($beforeDelete === true) {
    //         return $this->arrayToObject($this->store->deleteById($id), $this->domain);
    //     }
    //     return false;
    // }
    
    // /**
    //  * Busca todos os registros. (conforme regras do Sleek DB)
    //  * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
    //  * @param int $limit
    //  * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
    //  */
    // function findAll(array $orderBy = null, int $limit = null, int $offset = null)
    // {
    //     return $this->arrayToObject($this->store->findAll($orderBy, $limit, $offset), $this->domain);
    // }
    // function emptyValues()
    // {
    //     return $this->domain;
    // }

    /**
     * Retorna estrutura do Objeto vazia.
     */
    function empty()
    {
        return (array) $this->domain;
    }


    /**
     * Executa uma função da Classe domain.<br>
     * Primeiro parâmetro de $functionName deve ser é a variável store.
     * @param $functionName -> nome da função que deve executar.
     * @param $args -> parâmetros da função.
     */
    function executeFunction($functionName, $args = null) {
        if(is_null($args)) {
            return $this->domain->$functionName($this->store);
        }
        return $this->domain->$functionName($this->store, $args);
    }

    // /** 
    //  * Carrega objeto para o domínio.
    //  */
    // function loadObject($newObject) 
    // {
    //     $this->domain = $newObject;
    // }

    function getStore() 
    {
        return $this->store;
    }

    function getDomain() 
    {
        return $this->domain;
    }
}

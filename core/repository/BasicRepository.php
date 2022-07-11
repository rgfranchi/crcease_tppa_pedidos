<?php
namespace TPPA\CORE\repository;

use TPPA\CORE\store\BasicStore;

use function TPPA\CORE\basic\pr;

class BasicRepository extends BasicStore {


    protected $store = null;
    protected $domain = null;
    protected $disableAfterRead = false;

    /**
     * Carrega as classes para realizar as operações de store.
     * @param $domain string 
     */
    function __construct($domainName) {
        // verifica se existe store para sobrescrever.
        $_class = null;
        if(file_exists('app/store/'.$domainName.'Store.php')) {
            $_class = $this->instantiateClass('Store', $domainName);
            $this->store = $_class->getStore();
        } else {
            $_class = $this->store = $this->instantiateClass('Store', 'Basic', array($domainName. 'Store', $domainName), null, "CORE");
            $this->store = $_class->getStore();
        }
        $this->domain = $_class->getDomain();
    }


    /**
     * Cria novo registro.
     */
    function create($array)
    {   
        $array = $this->domain->beforeCreate($array);
        $this->domain->validateCreate($array, $_id = null);
        return $this->store->insert($array);
    }
    /**
     * Atualiza novo registro.
     */
    function update($array, $_id = null)
    {
        $array = $this->domain->beforeUpdate($array, $_id = null);
        $this->domain->validateUpdate($array, $_id = null);
        if($_id === null) {
            $_id = $array['_id'];
        }
        unset($array['_id']);
        return $this->store->updateById($_id,$array);
    }
    /**
     * Excluir um registro.<br>
     * Verifica cada objeto antes de excluir.
     * @param int $limit
     * @return objeto excluído ou false se não excluir.
     */
    function delete($id)
    {
        $beforeDelete = $this->domain->beforeDelete($id);
        $this->domain->validateDelete($id);
        if($beforeDelete === true) {
            return $this->store->deleteById($id);
        }
        return false;
    }


    function deleteBy($conditions)
    {
        $beforeDelete = $this->domain->beforeDelete($conditions);
        $this->domain->validateDelete($conditions);
        if($beforeDelete === true) {
            return $this->store->deleteBy($conditions);
        }
        return false;
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
        // verificar todos os valores.
        $data = $this->domain->beforeSave($data);
        if($this->domain->validateSave($data) !== true) {
            $this->basicFunctions->loadException("ERRO AO VALIDAR CAMPO.");
        };
        // verifica cada um dos campos.
        foreach(array_keys($data) as $key) {
            if(!property_exists($this->domain,$key)) {
                unset($data[$key]);
            }
        }
        if ($isNew) {
            return $this->create($data);
        } else {
            return $this->update($data);
        }
    }

    /**
     * Inclui ou salva um array de valores.
     */
    function saveAll($array)
    {
        if(!is_array($array)) {
            $this->basicFunctions->loadException("Array inválido.");
        }
pr($array);
die;
        foreach($array as $key => $values) {
            if(!is_array($values)) {
                $this->basicFunctions->loadException("ARRAY como valor Esperado.");
            }
            $ret[$key] = $this->save($values);
        }
        return $ret;
    }

    /**
     * Busca todos os registros. (conforme regras do Sleek DB)
     * @param array $orderBy [field => <'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findAll(array $orderBy = null, int $limit = null, int $offset = null)
    {
        $ret = $this->store->findAll($orderBy, $limit, $offset);
        foreach($ret as &$value) {
            $value = $this->afterRead($value);
        }
        return $ret;
    }

    /**
     * Busca por condição (conforme regras do Sleek DB)
     * @param $condition [field,param,value] ex.: ['nome', '==', 'James']
     * @param array $orderBy [field => 'asc' ou 'desc'] ex.: ['nome' => 'asc']
     * @param int $limit
     * @param int $offset [field,param,value] ex.: ['nome', '==', 'James']
     */
    function findBy($condition, array $orderBy = null, int $limit = null, int $offset = null)
    {
        $ret = $this->store->findBy($condition, $orderBy, $limit, $offset);
        foreach($ret as &$value) {
            $value = $this->afterRead($value);
        }
        return $ret;
    }
    /**
     * Retorna primeira ocorrência da busca.
     * @param $condition [field,param,value] ex.: ['nome', '==', 'James']
     * @param array $orderBy [field => 'asc' ou 'desc'] ex.: ['nome' => 'asc']
     */
    function firstBy($condition, array $orderBy = null)
    {
        $ret = $this->store->findBy($condition, $orderBy);
        foreach($ret as &$value) {
            $value = $this->afterRead($value);
        }
        return empty($ret) ? [] : $ret[0];
    }

    /**
     * Busca por id específico.
     */
    function findById($id)
    {
        return $this->afterRead($this->store->findById($id));
    }

    function disableAfterRead($bool = false) {
        $this->disableAfterRead = $bool;
    }

    private function afterRead($data) {
        if($this->disableAfterRead) {
            return $data;
        }
        return $this->domain->afterRead($data);
    }

    function subRepository($repository)
    {
        return $this->instantiateClass('Repository', $repository);
    }

}
<?php

namespace TPPA\CORE\mapper;

use TPPA\CORE\BasicSystem;

/**
 * Operações de transição entre domain e component.
 */
class BasicMapper extends BasicSystem
{
    public $domain = null;
    public $component = null;

    /**
     * Inicializa classe com as estruturas básicas. 
     * @param string $domain mantem estrutura de dados.
     * @param string $component mantem estrutura da view
     * @param string $store mantem store especifico do mapper.
     * @param string|boolean|null $store carrega estore, se falso não carrega, se null mesma store do $domain
     */
    function __construct($domain, $component, $store = null)
    {
        $this->domain = $this->loadDomain($domain);
        $this->component = $this->loadComponent($component);
        if(is_null($store)) {
            $this->store = $this->loadBasicStores($domain);
        } else {
            $this->store = $this->loadStores($store);
        }
    }

    /**
     * Retorna componente preenchido com valores de store.
     */
    function component() {
        $this->store->loadObject($this->component);
        return $this->store;
    }

    /**
     * Retorna domain preenchido com valores de store.
     */
    function domain() {
        $this->store->loadObject($this->domain);
        return $this->store;
    }

    /**
     * Retorna store
     */
    function getStore() {
        return $this->store;
    }


    /**
     * Verifica se o tipo tramitado é um array e se o pode ser convertido em objeto.
     * @param object/array *retorna na mesma variável enviada.
     */
    function verifyValue(&$value)
    {
        if (is_array($value)) {
            $firstKey = key($value);
            if (is_string($firstKey)) {
                $value = (object) $value;
            }
        }
    }

    /**
     * Converte objeto 'from' para 'to' mapeando os nomes das propriedades
     * @param objeto $objeto Objeto para conversão.
     * @param objeto $from objeto de origem
     * @param objeto $to de destino
     * @return objeto destino "to"
     */
    function mapper($object, $from, $to)
    {
        $newObject = new $to();
        foreach (array_keys((array) $from) as $key) {
            if (property_exists($to, $key)) {
                if (!is_null($object) && property_exists($object, $key)) {
                    $newObject->$key = $object->$key;
                } else {
                    $newObject->$key = null;
                }
            }
        }
        return $newObject;
    }

    /**
     * Lê domínio processado
     */
    function getDomain()
    {
        return $this->domain;
    }

    /**
     * Lê component processado
     */
    function getComponent()
    {
        return $this->component;
    }
}

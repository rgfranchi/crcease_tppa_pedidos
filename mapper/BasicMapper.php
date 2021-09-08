<?php

/**
 * Operações de transição entre domain e componet.
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
     * Carrega instancia do componente e reponde com instancia do domínio
     * @param object $loadComponent instancia a ser mapeada
     */
    // function directDomain($loadComponent)
    // {
    //     $this->verifyValue($loadComponent);
    //     if (empty($loadComponent)) {
    //         return $this->domain;
    //     }
    //     $ret = null;
    //     if (is_array($loadComponent)) {
    //         foreach ($loadComponent as $key => $value) {
    //             $ret[$key] = $this->mapper($value, $this->component, $this->domain);
    //         }
    //     } else {
    //         $ret = $this->mapper($loadComponent, $this->component, $this->domain);
    //     }
    //     $this->domain = $ret;
    // }

    // /**
    //  * Carrega instancia do domínio e reponde com instancia do componente
    //  * @param object $loadDomain instancia a ser mapeada
    //  */
    // function directComponent($loadDomain = null)
    // {
    //     $this->verifyValue($loadDomain);
    //     if (empty($loadDomain)) {
    //         return $this->component;
    //     }
    //     $ret = null;
    //     if (is_array($loadDomain)) {
    //         foreach ($loadDomain as $key => $value) {
    //             $ret[$key] = $this->mapper($value, $this->domain, $this->component);
    //         }
    //     } else {
    //         $ret = $this->mapper($loadDomain, $this->domain, $this->component);
    //     }
    //     $this->component = $ret;
    // }

    // function directComponentList($loadDomainList)
    // {
    //     if (empty($loadDomainList)) {
    //         $this->component = array();
    //     }
    //     $this->directComponent($loadDomainList);
    // }

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

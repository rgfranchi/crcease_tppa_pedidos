<?php

/**
 * Operações de transição entre domain e componet.
 */
class BasicMapper
{
    public $domain = null;
    public $component = null;

    /**
     * Inicializa classe com as estruturas basicas. 
     * @param string $domain mantem estrutura de dados.
     * @param string $component mantem estrutura da view
     */
    function __construct($domain = null, $component = null)
    {
        if(!is_null($domain)) {
            include_once __ROOT__. "/domain/" .$domain.".php";
            $this->domain = new $domain();
        }
        if(!is_null($component)) {
            $className = $component."Component";
            include_once __ROOT__. "/component/" .$className.".php";
            $this->component = new $className();
        }
    }

    /**
     * Carrega intancia do componente e reponde com intancia do dominio
     * @param object $loadComponent instancia a ser mapeada
     */
    function directDomain($loadComponent) {
        $this->verifyValue($loadComponent);
        $ret = null;
        if(is_array($loadComponent)) {
            foreach($loadComponent as $key => $value) {
                $ret[$key] = $this->mapper($value, $this->component, $this->domain);
            }
        } else {
            $ret = $this->mapper($loadComponent, $this->component, $this->domain);
        }
        $this->domain = $ret;
    }

    /**
     * Carrega intancia do dominio e reponde com intancia do componente
     * @param object $loadDomain instancia a ser mapeada
     */
    function directComponent($loadDomain = null) {
        $this->verifyValue($loadDomain);
        $ret = null;
        if(is_array($loadDomain)) {
            foreach($loadDomain as $key => $value) {
                $ret[$key] = $this->mapper($value, $this->domain, $this->component);
            }
        } else {
            $ret = $this->mapper($loadDomain, $this->domain, $this->component);
        }
        $this->component = $ret;
    }    

    /**
     * Verifica se o tipo tramitado é um array e se o pode ser convertido em objeto.
     * @param object/array *retorna na mesma variável enviada.
     */
    function verifyValue(&$value) {
        if(is_array($value)) {
            $firstKey = key($value);
            if(is_string($firstKey)) {
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
    function mapper($object, $from, $to) {
        $newObject = new $to();
        foreach(array_keys((array) $from) as $key) {
            if(property_exists($to,$key)) {
                if(!is_null($object) && property_exists($object,$key)) {
                    $newObject->$key = $object->$key;
                } else {
                    $newObject->$key = null;
                }
            }
        }
        return $newObject;
    }

    /**
     * Lê dominio processado
     */
    function getDomain() {
        return $this->domain;
    }

    /**
     * Lê component processado
     */
    function getComponent() {
        return $this->component;
    }
}
<?php

/**
 * Operações de transição entre domain e componet.
 */
class BasicMapper
{
    public $domain = null;
    public $component = null;

    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
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

    function directDomain($object) {
        $this->domain = $object;
    }

    function directComponent($loadDomain) {
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

    function mapper($object, $from, $to) {
        foreach(array_keys((array) $from) as $key) {
            if(property_exists($to,$key)) {
                if(property_exists($object,$key)) {
                    $to->$key = $object->$key;
                } else {
                    $to->$key = null;
                }
            }
        }
        return $to;
    }

    function getDomain() {
        return $this->domain;
    }

    function getComponent() {
        return $this->component;
    }
}
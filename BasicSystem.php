<?php

class BasicSystem
{

    function __construct()
    {
    }

    function loadDomain($domain)
    {
        return $this->instantiateClass('Domain', $domain);
    }

    function loadComponent($component)
    {
        return $this->instantiateClass('Component', $component);
    }

    /**
     * Utiliza classe BasicStores carregar ou criar um novo store SleekDB.
     * Retorna instancia em snake_case separado do store.
     */
    function loadBasicStores($storeName)
    {
        $store = $storeName . 'Store';
        $domain = $storeName;
        $this->{camelToSnakeCase($storeName)} = $this->instantiateClass('Store', 'Basic', array($store, $domain));
    }

    function loadStores($store)
    {
        $store = $this->instantiateClass('Store', $store);
    }

    /**
     * Carrega uma ou múltiplas classes
     * @param string $typeClass tipo da classe que será instanciado (Domain / Component / Mapper etc...)
     * @param string|array $class nome da classe ou array de classes será carregado.
     * @param string|null $parameters array com parâmetros, se mais de uma classe incluir como subarray
     * @param string|null $folderName local da classe (opcional)
     */
    function instantiateClass($typeClass, $class, $parameters = array(), $folderName = null)
    {
        $folderName = empty($folderName) ? strtolower($typeClass) : $folderName;
        $loadClasses = array();
        if (!is_array($class)) {
            $loadClasses[] = $class;
            $loadParameters[] = $parameters;
        } else {
            $loadClasses = $class;
            $loadParameters = $parameters;
        }
        $ret = array();
        foreach ($loadClasses as $key => $value) {
            $className = $value . $typeClass;
            include_once(__ROOT__ . "/" . $folderName . "/" . $className . ".php");
            $instanceName = camelToSnakeCase($value);
            $newClass = new ReflectionClass($className);

            if (!empty($loadParameters) && count($loadParameters[$key]) > 0) {
                $this->{$instanceName} = $newClass->newInstanceArgs($loadParameters[$key]);
            } else {
                $this->{$instanceName} = $newClass->newInstance();
            }
            $ret[] = $this->{$instanceName};
        }
        if (count($ret) == 1) {
            return $ret[0];
        }
        return $ret;
    }
}

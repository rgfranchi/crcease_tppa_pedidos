<?php

class BasicSystem
{
    function loadDomain($object)
    {
        return $this->instantiateClass('Domain', $object);
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
        $object = $storeName;
        $this->{camelToSnakeCase($storeName)} = $this->instantiateClass('Store', 'Basic', array($store, $object));
        return $this->{camelToSnakeCase($storeName)};
    }

    function loadStores($store)
    {
        $store = $this->instantiateClass('Store', $store);
    }

    function loadService($service)
    {
        $this->instantiateClass('Service', $service);
    }

    /**
     * Carrega uma ou múltiplas classes
     * @param string $typeClass tipo da classe que será instanciado (object$object / Component / Mapper etc...)
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

    /**
     * Converte Array em objeto.<br>
     * Objeto processado deve extender a classe RawObject.
     * Se for array com sub array, retorna array de objetos.<br>
     * Processo executado recursivamente.
     * @param array $array - array do banco de dados.
     * @param object $object - objeto tipo para conversão.
     */
    function arrayToObject($array, $object)
    {
        if (!is_array($array)) {
            return $array;
        }
        $ret = array();
        // cria novo objeto para inserção na lista ou retorno.
        $newObject = new $object;
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $ret[] = $this->arrayToObject($value, $object);
            } else {
                if(property_exists($newObject,$key)) {
                    $newObject->{$key} = $this->arrayToObject($value, $object);
                }
            }
        }

        if($object != $newObject) {
            // recebe configuração dos campos do objeto.
            $ret = $newObject->getObject();
        }
        return $ret;
    }


    /**
     * Converte Objeto em Array.<br>
     * Se array de objetos, retorna array com sub array .<br>
     * Processo executado recursivamente.
     * @param object|array $object - objeto para conversão.
     */
    function objectToArray($object)
    {
        if (!is_array($object)) {
            return $object->getObjectArray();
        }
        $ret = array();
        foreach ($object as $key => $value) {
            if (is_int($key)) {
                $ret[] = $this->objectToArray($value);
            } 
        }
        return $ret;
    }

}

<?php 

class BasicSystem {

    function __construct()
    {
    }

    function loadDomain($domain)
    {
        return $this->instantiateClass('Domain', $domain );
    }

    function loadComponent($component)
    {
        return $this->instantiateClass('Component', $component );
    }

    function instantiateClass($typeClass, $class, $folderName = null) {
        $folderName = empty($folderName) ? strtolower($typeClass) : $folderName;
        $loadClasses = array();
        if (!is_array($class)) {
            $loadClasses[] = $class;
        } else {
            $loadClasses = $class;
        }
        $ret = array();
        foreach ($loadClasses as $value) {
            $className = $value . $typeClass;
            include_once(__ROOT__ . "/".$folderName."/".$className . ".php");
            $ret[] = $this->{camelToSnakeCase($value)} = new $className();
        }
        if(count($ret) == 1) {
            return $ret[0];
        }
        return $ret;

    }


}
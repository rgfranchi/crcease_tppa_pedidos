<?php
namespace TPPA\CORE\controller;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\BasicSystem;

use function TPPA\CORE\basic\pr;

class BasicController extends BasicSystem
{
    public $stores = array();
    public $view;

    // /**
    //  * Utiliza classe BasicMapper para montar o mapeamento direto entre as classes.
    //  * Retorna instancia em snake_case separado por 'map' ex: classe_domain_map_classe_component
    //  * @see BasicMapper.
    //  */
    // function loadBasicMapper($domain, $component, $store = null)
    // {
    //     $basicFunctions = new BasicFunctions();
    //     $name = $basicFunctions->camelToSnakeCase($domain) . '_map_' . $basicFunctions->camelToSnakeCase($component);
    //     $this->{$name} = $this->instantiateClass('Mapper', 'Basic', array($domain, $component, $store), null, 'CORE');
    // }


    function loadRepository($repository)
    {
        return $this->instantiateClass('Repository', $repository);
    }

    // function loadMapper($mapper)
    // {
    //     $this->instantiateClass('Mapper', $mapper);
    // }

    /**
     * Inicializa domain instanciando classe(s) em camel_case<br>
     * @param string array com Domains. 
     * Cria: $this->{nome_domain} (camel case)
     */
    function storeDomain($domain)
    {
        $basicFunctions = new BasicFunctions();
        if(!is_array($domain)) {
            $arrDomain[] = $domain;
        }else {
            $arrDomain = $domain;
        }
        foreach($arrDomain as $value) {
            // verifica se existe store para sobrescrever.
            $className = $basicFunctions->camelToSnakeCase($value);
            if(file_exists('app/store/'.$value.'Store.php')) {
                $this->{$className} = $this->instantiateClass('Store', $value);
            } else {
                $this->{$className} = $this->instantiateClass('Store', 'Basic', array($value. 'Store', $value), null, "CORE");
            }
        }
    }

    // /**
    //  * Inicializa componente instanciando classe(s) em camel_case<br>
    //  * Cria mapeamento entre o domain e componente. (deve ter campos iguais)
    //  * @param $domain string Domain.
    //  * @param $component string ou array com Componente alimentado.
    //  * 
    //  */
    // function mapperComponent($domain, $component) 
    // {
    //     $basicFunctions = new BasicFunctions();
    //     if(!is_array($component)) {
    //         $arrComponent[] = $component;
    //     }else {
    //         $arrComponent = $component;
    //     }
    //     foreach($arrComponent as $value) {
    //         $className = $basicFunctions->camelToSnakeCase($value);
    //         $this->{$className} = $this->instantiateClass('Mapper', 'Basic', array($domain, $value, null), null, 'CORE')->component();
    //     }        
    // }


    /**
     * Carrega View.
     * @param string $view_folder subpasta de view.
     */
    function loadView($view_folder)
    {
        $this->view = $this->instantiateClass('View', 'Basic', array($view_folder), null, "CORE");
    }
}

<?php

require_once(__ROOT__ . '/config.php');

class BasicController extends BasicSystem
{
    public $stores = array();
    public $view;
    function __construct()
    {
    }

    // /**
    //  * Utiliza classe BasicStores carregar ou criar um novo store SleekDB.
    //  * Retorna instancia em snake_case separado do store.
    //  */
    // function loadBasicStores($storeName)
    // {
    //     $store = $storeName . 'Store';
    //     $domain = $storeName;
    //     $this->{camelToSnakeCase($storeName)} = $this->instantiateClass('Store', 'Basic', array($store, $domain));
    // }

    // function loadStores($store)
    // {
    //     $store = $this->instantiateClass('Store', $store);
    // }

    /**
     * Utiliza classe BasicMapper para montar o mapeamento direto entre as classes.
     * Retorna instanciar em snake_case separado por 'map' ex: classe_domain_map_classe_component
     */
    function loadBasicMapper($domain, $component)
    {
        $name = camelToSnakeCase($domain) . '_map_' . camelToSnakeCase($component);
        $this->{$name} = $this->instantiateClass('Mapper', 'Basic', array($domain, $component));
    }

    function loadMapper($mapper)
    {
        $this->instantiateClass('Mapper', $mapper);
    }

    function loadService($service)
    {
        $this->instantiateClass('Service', $service);
    }

    /**
     * Carrega View.
     * @param string $view_folder subpasta de view.
     */
    function loadView($view_folder)
    {
        $this->view = $this->instantiateClass('View', 'Basic', array($view_folder));
    }
}

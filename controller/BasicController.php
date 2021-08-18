<?php

require_once(__ROOT__ . '/config.php');

class BasicController extends BasicSystem
{
    public $stores = array();
    public $view;

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

    /**
     * Carrega View.
     * @param string $view_folder subpasta de view.
     */
    function loadView($view_folder)
    {
        $this->view = $this->instantiateClass('View', 'Basic', array($view_folder));
    }
}

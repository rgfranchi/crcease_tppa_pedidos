<?php
namespace TPPA\CORE\controller;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\BasicSystem;

class BasicController extends BasicSystem
{
    public $stores = array();
    public $view;

    /**
     * Utiliza classe BasicMapper para montar o mapeamento direto entre as classes.
     * Retorna instancia em snake_case separado por 'map' ex: classe_domain_map_classe_component
     * @see BasicMapper.
     */
    function loadBasicMapper($domain, $component, $store = null)
    {
        $basicFunctions = new BasicFunctions();
        $name = $basicFunctions->camelToSnakeCase($domain) . '_map_' . $basicFunctions->camelToSnakeCase($component);
        $this->{$name} = $this->instantiateClass('Mapper', 'Basic', array($domain, $component, $store), null, 'CORE');
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
        $this->view = $this->instantiateClass('View', 'Basic', array($view_folder), null, "CORE");
    }
}

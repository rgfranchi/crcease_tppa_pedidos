<?php

require_once(__ROOT__ . '/config.php');

class BasicController extends BasicSystem
{
    public $stores = array();
    public $view;
    function __construct()
    {
    }

    function loadStores($store)
    {
        $this->instantiateClass('Store', $store);
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
     * @param string/Objeto $componentName nome do component ou objeto utilizado data.
     */
    function loadView($view_folder)
    {
        include_once(__ROOT__ . "/view/BasicView.php");
        $this->view = new BasicView($view_folder);
    }
}

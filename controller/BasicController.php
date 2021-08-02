<?php

require_once(__ROOT__ . '/config.php');

class BasicController
{
    public $stores = array();
    public $view;
    function __construct()
    {
    }

    function loadStores($stores)
    {
        $loadStores = array();
        if (!is_array($stores)) {
            $loadStores[] = $stores;
        } else {
            $loadStores = $stores;
        }
        foreach ($loadStores as $value) {
            $className = $value . 'Store';
            include_once(__ROOT__ . "/store/" . $className . ".php");
            $this->{camelToSnakeCase($value)} = new $className();
        }
    }


    function loadMapper($mapper)
    {
        $loadMappers = array();
        if (!is_array($mapper)) {
            $loadMappers[] = $mapper;
        } else {
            $loadMappers = $mapper;
        }
        foreach ($loadMappers as $value) {
            $className = $value . 'Mapper';
            include_once(__ROOT__ . "/mapper/" . $className . ".php");
            $this->{camelToSnakeCase($value)} = new $className();
        }
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

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
            include_once(__ROOT__ . "/stores/" . $className . ".php");
            $this->{strtolower($value)} = new $className();
        }
    }

    function loadView($view_folder)
    {
        include_once(__ROOT__ . "/view/BasicView.php");
        $this->view = new BasicView($view_folder);
    }
}

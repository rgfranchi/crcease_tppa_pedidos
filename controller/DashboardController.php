<?php

include 'BasicController.php';

class DashboardController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadView('dashboard');
    }

    function index()
    {
        $this->view->render("index");
    }
}

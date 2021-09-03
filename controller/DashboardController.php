<?php

include 'BasicController.php';

class DashboardController extends BasicController
{
    function __construct()
    {
        $this->loadView('dashboard');
    }

    function index()
    {
        $this->view->render("index");
    }
}

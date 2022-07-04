<?php

namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

// include 'BasicController.php';

class DashboardController extends BasicController
{
    function __construct()
    {
        $this->mapperComponent("PedidoPregao", "DashboardIndex");
        $this->loadView('dashboard');
    }

    function index()
    {   
        $this->view->render("index", $this->dashboard_index->executeFunction("loadIndex"));
    }
}

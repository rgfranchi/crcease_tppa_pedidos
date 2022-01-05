<?php

include 'BasicController.php';

class DashboardController extends BasicController
{
    function __construct()
    {
        $this->loadMapper('PedidoPregaoMapDashboardIndex');

        $this->loadView('dashboard');
    }

    function index()
    {   
        $this->view->render("index", $this->pedido_pregao_map_dashboard_index->loadIndex());
    }
}

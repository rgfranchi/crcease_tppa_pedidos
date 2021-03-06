<?php

namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class DashboardController extends BasicController
{
    function __construct()
    {
        $this->loadView('dashboard');
        $this->pedidoPregaoRepository = $this->loadRepository("PedidoPregao");
    }

    function index()
    {   
        $this->view->render("index", $this->pedidoPregaoRepository->dashboard());
    }
}

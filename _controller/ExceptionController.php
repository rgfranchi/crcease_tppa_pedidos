<?php

include 'BasicController.php';

class ExceptionController extends BasicController
{
    function __construct()
    {
        $this->loadView('exception');
    }

    function access_denied()
    {
        $this->view->render("access_denied");
    }
}
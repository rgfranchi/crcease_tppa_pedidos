<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

// include 'BasicController.php';

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

    function delete($message = "") {
        $this->view->render("delete", $message);
    }
}
<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

// include_once('BasicController.php');

class SessionController extends BasicController
{

    function __construct()
    {
        $this->loadView('');
    }

    function menu()
    {
        $_SESSION['menu']['toggled'] = !$_SESSION['menu']['toggled'];
    }

    function login()
    {
        $postLogin = $this->view->dataPost();
        if($postLogin['login'] === "admin") {
            $_SESSION['login']['admin'] = true;
        }
        $this->view->reloadHistory();
    }

    function logout()
    {
        unset($_SESSION['login']);
        $this->view->reloadHistory();
    }

    function del()
    {
        pr($_SESSION);
        unset($_SESSION);
        pr($_SESSION);
    }    

}
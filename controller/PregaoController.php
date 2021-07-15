<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores('Pregao');
        $this->loadView('pregao');
    }
    function index()
    {
        $this->view->render("index", $this->pregao->findAll());
    }
    function add()
    {
        $this->view->render("form");
    }
    function edit()
    {
        $getId = $this->view->getData()['get']['id'];
        $this->view->render("form", $this->pregao->findById($getId));
    }
    function save()
    {
        $post = $this->view->getData()['post'];
        $this->pregao->save($post);
        $this->view->redirect('Pregao', "index");
    }
    function delete()
    {
        $get = $this->view->getData()['get'];
        $this->pregao->delete($get['id']);
        $this->view->redirect('Pregao', "index");
    }
}

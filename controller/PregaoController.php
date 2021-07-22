<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores('Pregao');
        $this->loadView('pregao');
        $this->loadMappper('PregaoToPregaoList');
    }
    function index()
    {
        $this->pregao_to_pregao_list->directComponent($this->pregao->findAll());
        $this->view->render("index", $this->pregao_to_pregao_list->getComponent());
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

<?php

include 'BasicController.php';

class PregaoItensController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores(array('Pregao', 'PregaoItens'));
        $this->loadView('pregao_itens');
    }

    function index()
    {
        $pregaoId = $this->view->getData()['get']['pregao_id'];
        $res = $this->pregao->findById($pregaoId);
        $this->view->render("index", $res);
    }
    function add()
    {
        $pregao_id = $this->view->getData()['get']['pregao_id'];
        $this->view->setData(array('pregao_id' => $pregao_id));
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
        $load_pregao = $this->pregao->findById($post['pregao_id']);
        $load_pregao->pregao_itens[] = $post;
        $this->pregao->save($load_pregao);
        $this->view->redirect('PregaoItens', "index");
    }
    function delete()
    {
        $get = $this->view->getData()['get'];
        $this->pregao->delete($get['id']);
        $this->view->redirect('Pregao', "index");
    }
}

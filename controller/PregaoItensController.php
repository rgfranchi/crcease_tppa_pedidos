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
        $res = $this->pregao->joinToObjectById($pregaoId, $this->pregao_itens, 'pregao_id');

recuperar os itens junto com o pregão.

        pr($res);
        die;

        $this->view->render("index", $res);
    }
    function add()
    {
        pr('add');
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
        $this->pregao->save($post);
        $this->view->redirect('Pregao', "index");
    }
    function delete()
    {
        $get = $this->view->getData()['get'];
        $data = $this->pregao->delete($get['id']);
        $this->view->redirect('Pregao', "index");
    }
}

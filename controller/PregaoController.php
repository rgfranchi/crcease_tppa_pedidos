<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadBasicStores('Pregao');
        $this->loadView('pregao');
        $this->loadBasicMapper("Pregao", "PregaoList");
        $this->loadBasicMapper("Pregao", "PregaoForm");
    }

    function index()
    {
        $this->pregao_map_pregao_list->directComponentList($this->pregao->findAll());
        $this->view->setTitle("Lista Pregões");
        $this->view->render("index", $this->pregao_map_pregao_list->getComponent());
    }
    function add()
    {
        $this->pregao_map_pregao_form->directComponent();
        $this->view->setTitle("Cadastra Pregão");
        $this->view->render("form", $this->pregao_map_pregao_form->getComponent());
    }
    function edit()
    {
        $this->pregao_map_pregao_form->directComponent($this->pregao->findById($this->view->getData()['get']['id']));
        $this->view->setTitle("Edita Pregão");
        $this->view->render("form", $this->pregao_map_pregao_form->getComponent());
    }
    function save()
    {
        $post = $this->view->getData()['post'];
        $this->pregao_map_pregao_form->directDomain($post);
        $this->pregao->save($this->pregao_map_pregao_form->getDomain());
        $this->view->redirect('Pregao', "index");
    }
    function delete()
    {
        $get = $this->view->getData()['get'];
        $this->pregao->delete($get['id']);
        $this->view->redirect('Pregao', "index");
    }
}

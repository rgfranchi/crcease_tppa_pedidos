<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores('Pregao');
        $this->loadView('pregao');
        $this->loadMapper('PregaoToPregaoList');
        $this->loadMapper('PregaoToPregaoForm');
        $this->loadMapper('PregaoFormToPregao');
    }
    function index()
    {
        $this->pregao_to_pregao_list->directComponentList($this->pregao->findAll());
        $this->view->render("index", $this->pregao_to_pregao_list->getComponent());
    }
    function add()
    {
        $this->pregao_to_pregao_form->directComponent();
        $this->view->render("form", $this->pregao_to_pregao_form->getComponent());
    }
    function edit()
    {
        $this->pregao_to_pregao_form->directComponent($this->pregao->findById($this->view->getData()['get']['id']));
        $this->view->render("form", $this->pregao_to_pregao_form->getComponent());
    }
    function save()
    {
        $post = $this->view->getData()['post'];
        $this->pregao_form_to_pregao->directDomain($post);
        $this->pregao->create($this->pregao_form_to_pregao->getDomain());
        $this->view->redirect('Pregao', "index");
    }
    function delete()
    {
        $get = $this->view->getData()['get'];
        $this->pregao->delete($get['id']);
        $this->view->redirect('Pregao', "index");
    }
}

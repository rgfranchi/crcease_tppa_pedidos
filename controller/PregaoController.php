<?php

include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('pregao');
        $this->loadBasicMapper("Pregao", "PregaoList");
        $this->loadBasicMapper("Pregao", "PregaoForm");
    }

    function index()
    {

desabilitar o uso do campo valor total assim como quantidade total.
O campo deve ser controlado pelos itens cadastrados.

        $this->view->setTitle("Lista Pregões");
        $this->view->render("index", $this->pregao_map_pregao_list->component()->findAll(['nome' => 'asc']));
    }

    function add()
    {
        $this->view->setTitle("Cadastra Pregão");
        $this->view->render("form", $this->pregao_map_pregao_form->component()->emptyValues());
    }

    function edit()
    {
        $this->view->setTitle("Edita Pregão");
        $this->view->render("form", $this->pregao_map_pregao_form->component()->findById($this->view->dataGet()['id']));
    }

    function save()
    {
        $this->pregao_map_pregao_form->domain()->save($this->view->dataPost());
        $this->view->redirect("Pregao", "index");
    }

    function delete()
    {
        $this->pregao_map_pregao_list->domain()->delete($this->view->dataGet()['id']);
        $this->view->redirect("Pregao", "index");
    }
}

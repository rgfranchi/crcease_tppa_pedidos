<?php
namespace TPPA\APP\controller;
use TPPA\CORE\controller\BasicController;

class DemandaController extends BasicController {

    function __construct()
    {
        $this->loadView('demanda');
        $this->storeDomain('Demanda');
    }

    function index() {
        $this->view->setTitle("Lista de Demanda");
        // $list = $this->demanda_list->findAll();
        $list = $this->demanda->findAll();
        $this->view->render("index", $list);
    }

    function add()
    {
        $this->view->setTitle("Criar Demanda");
        $form = $this->demanda->emptyValues();
        $this->view->render("form", $form);
    }

    function update()
    {
        $this->view->setTitle("Atualizar Demanda");
        $form = $this->demanda->findById($this->view->dataGet()["id"]);
        $this->view->render("form", $form);
    }

    function save() 
    {
        $post = $this->view->dataPost();
        $this->demanda->save($post);
        $this->view->redirect("Demanda", "index");
    }
}

?>
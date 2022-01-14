<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

// include 'BasicController.php';

class PregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('pregao');
        $this->loadBasicMapper("Pregao", "PregaoList");
        $this->loadBasicMapper("Pregao", "PregaoForm");
        $this->loadService(array(
            'PhpSpreadsheet',
        ));        
    }

    function index()
    {
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

    function download_file()
    {
        $obj = $this->loadBasicStores("Pregao")->findAll(['nome' => 'asc']);
        $file_path = $this->php_spreadsheet->saveFile($obj, 'tmp_file');
        $this->view->download($file_path, "Pregao", "index");
    }

}

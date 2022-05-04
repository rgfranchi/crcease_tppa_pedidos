<?php
namespace TPPA\APP\controller;

use TPPA\APP\component\DemandaFormComponent;
use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class DemandaController extends BasicController {

    function __construct()
    {
        $this->loadView('demanda');
        $this->loadBasicMapper('Demanda', 'DemandaList');
        $this->loadBasicMapper('Demanda', 'DemandaForm');
    }

    function index() {
        $this->view->setTitle("Lista de Demanda");
        $demanda = $this->demanda_map_demanda_list->component()->findAll();
        $this->view->render("index", $demanda);
    }

    function add()
    {

incluir itens no repositorio.        
        $this->view->setTitle("Criar Demanda");
        $this->view->render("form", $this->demanda_map_demanda_form->component()->emptyValues());
    }

    function update()
    {
        $this->view->setTitle("Atualizar Demanda");
        $this->view->render("form", $this->demanda_map_demanda_form->component()->findById($this->view->dataGet()["id"]));
    }

    function save() 
    {
        $this->demanda_map_demanda_list->domain()->save($this->view->dataPost());
        $this->view->redirect("Demanda", "index");
    }
}

?>
<?php
namespace TPPA\APP\controller;

use TPPA\APP\component\DemandaFormComponent;
use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class RepositorioController extends BasicController {

    function __construct()
    {
        $this->loadView('repositorio');
        $this->loadBasicMapper('Repositorio', 'RepositorioList');
        $this->loadBasicMapper('Repositorio', 'RepositorioForm');
    }

    function index($data) {

        pr($data);

        // $array = [
        //     (object) array(
        //         '_id' => 0,
        //         'nome' => "UPS", // repositório de produtos
        //         'descricao' => 'UPS 1212 - 123123', // repositório de produtos
        //         'total_quantidade' => 100, // soma demanda 1 item p/ N demandas
        //         'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
        //     ),
        //     (object) array(
        //         '_id' => 0, 
        //         'nome' => "RETIFICADOR", 
        //         'descricao' => 'RETIFICADOR DE X kVA ...',
        //         'total_quantidade' => 100,
        //         'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
        //     ),
        //     (object) array(
        //         '_id' => 2,
        //         'nome' => "BATERIA 12V ...", 
        //         'descricao' => 'Lithium ',
        //         'total_quantidade' => 100,
        //         'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
        //     ),
        //     (object) array(
        //         '_id' => 3,
        //         'nome' => "BATERIA 12V ...", 
        //         'descricao' => 'Chumbo acido ... ',
        //         'total_quantidade' => 100,
        //         'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
        //     ),
        // ];

        $this->view->title = "Repositorio";

        $this->view->setTitle("Itens do Repositório");
        $repositorio = $this->repositorio_map_repositorio_list->component()->findAll();
        $this->view->render("index", $repositorio);
    }
    
    function add()
    {
        $this->view->setTitle("Novo Item de Repositorio");
        $this->view->render("form", $this->repositorio_map_repositorio_form->component()->emptyValues());
    }

    function update()
    {
        $this->view->setTitle("Atualizar Item de Repositorio");
        $this->view->render("form", $this->repositorio_map_repositorio_form->component()->findById($this->view->dataGet()["id"]));
    }

    function save() 
    {
        $this->demanda_map_demanda_list->domain()->save($this->view->dataPost());
        $this->view->redirect("Repositorio", "index");
    }
}

?>
<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class DemandaController extends BasicController {

    function __construct()
    {
        $this->loadView('demanda');
    }


    function index() {
        $array = [
            (object) array(
                '_id' => 0,
                'descricao' => 'EML - Material Permanente',
            ),
            (object) array(
                '_id' => 1,
                'descricao' => 'EML - Material Consumo',
            ),
            (object) array(
                '_id' => 2,
                'descricao' => 'EML - Material Serviço',
            ),
            (object) array(
                '_id' => 3,
                'descricao' => 'TEL - Material Permanente',
            ),
            (object) array(
                '_id' => 4,
                'descricao' => 'TEL - Material Consumo',
            ),
            (object) array(
                '_id' => 5,
                'descricao' => 'TEL - Material Serviço',
            ),
            (object) array(
                '_id' => 6,
                'descricao' => 'STI - Aquisição de Software',
            ),
            (object) array(
                '_id' => 7,
                'descricao' => 'STI - Material Permanente',
            ),
            (object) array(
                '_id' => 8,
                'descricao' => 'STI - Material Consumo',
            ),
        ];

        $this->view->title = "Lista de Demanda";
        $this->view->render("index", $array);
    }


    function list_demanda() {
        $array = [
            (object) array(
                '_id' => 0,
                'nome' => "UPS", // repositório de produtos
                'descricao' => 'UPS 1212 - 123123', // repositório de produtos
                'total_quantidade' => 100, // soma demanda 1 item p/ N demandas
                'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
            ),
            (object) array(
                '_id' => 0, 
                'nome' => "RETIFICADOR", 
                'descricao' => 'RETIFICADOR DE X kVA ...',
                'total_quantidade' => 100,
                'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
            ),
            (object) array(
                '_id' => 2,
                'nome' => "BATERIA 12V ...", 
                'descricao' => 'Lithium ',
                'total_quantidade' => 100,
                'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
            ),
            (object) array(
                '_id' => 3,
                'nome' => "BATERIA 12V ...", 
                'descricao' => 'Chumbo acido ... ',
                'total_quantidade' => 100,
                'solicitantes' => ['CAP Alfa', "TEN Bravo", "Sgt Delta"]
            ),
        ];

        $this->view->title = "Itens solicitados";
        $this->view->render("list_demanda", $array);

    }


}

?>
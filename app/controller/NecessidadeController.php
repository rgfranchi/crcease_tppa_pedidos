<?php

namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class NecessidadeController extends BasicController
{
    function __construct()
    {
        $this->loadView('necessidade');
        $this->pedidoPregaoRepository = $this->loadRepository("Necessidade");
    }

    function index()
    {   
        $data = 
            [["_id" => 1,
            "nome" => "NOME PROJETO",
            "objeto" => "OBJETO ..... ",
            "justificativa_necessidade" => "JUSTIFICATIVA ..... ",
            "projeto" => "PROJETO ... ",
            "integrante_tecnico" => "FULANO TÉCNICO",
            "integrante_requisitante" => "FULANO REQUISITANTE",
            "ativo" => 'true',
            "observacao" => "QUALQUER QUE SEJA.... "]];

        $this->view->render("index", $data);
    }
    function download_index(){
        pr("teste");
    } 
    
    
    function add() {
        $data = 
            ["_id" => 1,
            "nome" => "NOME PROJETO",
            "objeto" => "OBJETO ..... ",
            "justificativa_necessidade" => "JUSTIFICATIVA ..... ",
            "projeto" => "PROJETO ... ",
            "integrante_tecnico" => "FULANO TÉCNICO",
            "integrante_requisitante" => "FULANO REQUISITANTE",
            "ativo" => 'true',
            "observacao" => "QUALQUER QUE SEJA.... "];
        $this->view->render("form");
    }

    function edit() {
        $data = 
            ["_id" => 1,
            "nome" => "NOME PROJETO",
            "objeto" => "OBJETO ..... ",
            "justificativa_necessidade" => "JUSTIFICATIVA ..... ",
            "projeto" => "PROJETO ... ",
            "integrante_tecnico" => "FULANO TÉCNICO",
            "integrante_requisitante" => "FULANO REQUISITANTE",
            "ativo" => 'true',
            "observacao" => "QUALQUER QUE SEJA.... "];
        $this->view->render("form", $data);
    }

    function save() {
        // pr($post = $this->view->dataPost());
        $this->view->redirect("Necessidade", "index");
    }

    function add_itens() {
        $data['value'] = 
            [
                "_id" => 1,
                "nome" => "NOME PROJETO",
                "objeto" => "OBJETO ..... ",
                "justificativa_necessidade" => "JUSTIFICATIVA ..... ",
                "projeto" => "PROJETO ... ",
                "integrante_tecnico" => "FULANO TÉCNICO",
                "integrante_requisitante" => "FULANO REQUISITANTE",
                "ativo" => 'true',
                "observacao" => "QUALQUER QUE SEJA.... ",
                "necessidade_itens" => [
                    [
                        "cod_item" => 1,
                        "nome" => "item 1",
                        "descricao" => "Descrição 1",
                        "requisicao_minima" => 10,
                        "requisicao_maxima" => 1000,
                        "valor_medio" => 1.99,
                        "numero_catalogo" => '54321',
                        "justificativa_quantidade" => 'Aplicação em X, Y e Z',
                    ],
                    [
                        "cod_item" => 2,
                        "nome" => "item 2",
                        "descricao" => "Descrição 2",
                        "requisicao_minima" => 20,
                        "requisicao_maxima" => 2000,
                        "valor_medio" => 2.99,
                        "numero_catalogo" => '65432',
                        "justificativa_quantidade" => 'Aplicação em X, Y e Z',
                    ]
                ]
            ];
        $data['update'] = [
            "cod_item" => 1,
            "nome" => "item 1",
            "descricao" => "Descrição 1",
            "requisicao_minima" => 10,
            "requisicao_maxima" => 1000,
            "valor_medio" => 1.99,
            "numero_catalogo" => '54321',
            "justificativa_quantidade" => 'Aplicação em X, Y e Z',
        ];    
        $this->view->render("form_itens", $data);
    }


    function save_item() {
        // pr($post = $this->view->dataPost());
        $this->view->redirect("Necessidade", "add_itens");
    }
}
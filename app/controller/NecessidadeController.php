<?php

namespace TPPA\APP\controller;

use TPPA\APP\domain\NecessidadeItemDomain;
use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class NecessidadeController extends BasicController
{
    function __construct()
    {
        $this->loadView('necessidade');
        $this->necessidadeRepository = $this->loadRepository("Necessidade");
    }

    function index()
    {   
        $data = $this->necessidadeRepository->findAll();
        $this->view->render("index", $data);
    }
    function download_index(){
        pr("teste");
    } 
    
    
    function add() {
        $this->view->render("form");
    }

    function edit() {
        $get = $this->view->dataGet();
        $data = $this->necessidadeRepository->findById($get['id']);
        $this->view->render("form", $data);
    }

    function save() {
        $this->necessidadeRepository->save($this->view->dataPost());
        $this->view->redirect("Necessidade", "index");
    }

    function add_itens() {
        $get = $this->view->dataGet();
        $projeto = $this->necessidadeRepository->findById($get['necessidade_id']);
        $data['value'] = $projeto;
        $data['update'] = (array) new NecessidadeItemDomain();
        if(isset($get['item_key'])) {
            $data['update'] = $projeto['necessidade_itens'][$get['item_key']];
        }
        
        // $data['value'] = 
        //     [
        //         "_id" => 1,
        //         "nome" => "NOME PROJETO",
        //         "objeto" => "OBJETO ..... ",
        //         "justificativa_necessidade" => "JUSTIFICATIVA ..... ",
        //         "projeto" => "PROJETO ... ",
        //         "integrante_tecnico" => "FULANO TÉCNICO",
        //         "integrante_requisitante" => "FULANO REQUISITANTE",
        //         "ativo" => 'true',
        //         "observacao" => "QUALQUER QUE SEJA.... ",
        //         "necessidade_itens" => [
        //             [
        //                 "cod_item" => 1,
        //                 "nome" => "item 1",
        //                 "descricao" => "Descrição 1",
        //                 "requisicao_minima" => 10,
        //                 "requisicao_maxima" => 1000,
        //                 "valor_medio" => 1.99,
        //                 "numero_catalogo" => '54321',
        //                 "justificativa_quantidade" => 'Aplicação em X, Y e Z',
        //             ],
        //             [
        //                 "cod_item" => 2,
        //                 "nome" => "item 2",
        //                 "descricao" => "Descrição 2",
        //                 "requisicao_minima" => 20,
        //                 "requisicao_maxima" => 2000,
        //                 "valor_medio" => 2.99,
        //                 "numero_catalogo" => '65432',
        //                 "justificativa_quantidade" => 'Aplicação em X, Y e Z',
        //             ]
        //         ]
        //     ];
        // $data['update'] = [
        //     "cod_item" => 1,
        //     "nome" => "item 1",
        //     "descricao" => "Descrição 1",
        //     "requisicao_minima" => 10,
        //     "requisicao_maxima" => 1000,
        //     "valor_medio" => 1.99,
        //     "numero_catalogo" => '54321',
        //     "justificativa_quantidade" => 'Aplicação em X, Y e Z',
        // ];    
        $this->view->render("form_itens", $data);
    }


    /**
     * Salva elemento relacionado de subitem.
     */
    function save_item() {
        $item = $this->view->dataPost();
        $necessidade_id = $item['necessidade_id'];
        $necessidade = $this->necessidadeRepository->findById($necessidade_id);
        unset($item['necessidade_id']);
        $itens = $necessidade['necessidade_itens'];
        if(empty($item['cod_item'])) {
            // recupera ultimo elemento.
            $lastItem = end($itens);
            pr($lastItem);
            // verifica se existe itens no array soma um ao ultimo item.
            if(empty($lastItem)) {
                $new_cod_item = 1;
            } else {
                $new_cod_item = $lastItem['cod_item'] + 1;
            }
            $item['cod_item'] = $new_cod_item;
            $itens[$new_cod_item] = $item;
        } else {
            $item[$item['cod_item']] = $item;
        }
        
        pr($itens);
        // ordena itens pelo código item.
        // usort($itens, function($a, $b) {return strcmp($a['cod_item'], $b['cod_item']);});
        pr($itens);
        $projeto['necessidade_itens'] = $itens;
        pr($projeto);


        $this->necessidadeRepository->save($projeto);
        die;
        $this->view->redirect("Necessidade", "add_itens", [['necessidade_id' => $necessidade_id]]);
    }
}
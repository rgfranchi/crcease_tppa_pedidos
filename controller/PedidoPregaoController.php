<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

include 'BasicController.php';

class PedidoPregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('pedido_pregao');
        $this->loadBasicMapper('Pregao', 'PregaoHead');
        $this->loadBasicMapper('Pregao', 'PedidoPregaoList');
        $this->loadBasicMapper('ItemPregao', 'PedidoItemPregaoList','ItemPregao');
        
        $this->loadBasicMapper('PedidoPregao', 'PedidoPregaoData');
        $this->loadService(array(
            'ItemPregaoCalculation'
        ));
        $this->loadBasicMapper("Pregao", "PregaoInfo");
    }

    function index()
    {
        $this->view->setTitle("Pedido Pregão");
        $this->view->render("index", $this->pregao_map_pedido_pregao_list->component()->findAll());
    }
    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $pregao_itens = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        $pedidos = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id]);
        $data['itens'] = $this->item_pregao_calculation->disponiveis($pregao_itens, $pedidos);
        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("itens_list", $data);
    }

    /**
     * Pregões disponíveis.
     */
    function edit()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        // $pregao_itens = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        $data['pedido'] = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id], ["hashCredito" => "DESC"]);
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        // $data['itens'] = $this->item_pregao_calculation->disponiveis($pregao_itens, $pedidos);
        $this->view->setTitle("Consultar Pedido");
        $this->view->render("edit_pedido", $data);
    }
    /**
     * Consultar itens solicitados.
     */
    function edit_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        // Pedido selecionado.
        $data['pedido'] = $this->pedido_pregao_map_pedido_pregao_data->component()->findById($pedido_pregao_id);
        $pregao_id = $data['pedido']->pregao_id;
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        // Itens do pregão relacionado ao pedido.
        $pregao_itens = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        // Outros pedidos realizados exceto o atual.
        $pedidos = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(
            [
                ["pregao_id", "==", $pregao_id],
                "AND",
                [ "_id","<>",$pedido_pregao_id]
            ]
        );
        // Calcula quantidade disponível.
        $data['itens'] = $this->item_pregao_calculation->disponiveis($pregao_itens, $pedidos);


        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);
    }
    /**
     * Altera o o pedido de solicitado até aprovado.
     */
    function edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao_map_pedido_pregao_data->component()->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;
        $data['status'] = $this->pedido_pregao_map_pedido_pregao_data->getDomain()->statusPedido("PEDIDO");
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedido'] = $this->item_pregao_calculation->solicitados($pedido);
        $this->view->setTitle("Pedido SOLICITADOS");
        $this->view->render("edit_solicitado", $data);
    }
    /**
     * Altera o pedido de aprovados até empenhado.
     */
    function edit_aprovado() {
        $getPedido = $this->view->dataGet();
        $pregao_id = $getPedido['pregao_id'];
        $hashCredito = $getPedido['hash_credito'];
        $data['pedido_status'] = $getPedido['pedido_status'];
        $data['status'] = $this->pedido_pregao_map_pedido_pregao_data->getDomain()->statusPedido("CREDITO");

        $pedido = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy([
            ["pregao_id", "==", $pregao_id],
            "AND",
            ["status", "IN", $data['status']],
            "AND",
            ["hashCredito", "==", $hashCredito]
        ]);
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedidos'] = $this->item_pregao_calculation->total_aprovados($pedido, $pregao_id);
        $data['hash_credito'] = $hashCredito;
        $this->view->setTitle("Pedidos APROVADOS");
        $this->view->render("edit_aprovado", $data);
    }


    function save()
    {
        $ret = $this->pedido_pregao_map_pedido_pregao_data->domain()->save($this->view->dataPost());
        $this->view->redirect("PedidoPregao", "edit", array('pregao_id' => $ret->pregao_id));
    }
    function saveMany()
    {
        $post = $this->view->dataPost();
        $idsPost = $post['_ids'];
        $statusPost = $post['status'];
        $hashCredito =$post['hash_credito'];
        if(empty($hashCredito)) {
            $date = new DateTime();
            $hashCredito = $date->format('YmdHis');
        } 
        // desfaz a operação de Crédito
        if($statusPost === "APROVADO") {
            $hashCredito = "";
        }

        $postData = array();
        foreach(json_decode($idsPost) as $id) {
            $postData[] = array(
                "_id" =>  $id,
                "status" => $statusPost,
                "hashCredito" => $hashCredito
            );
        }
        $ret = $this->pedido_pregao_map_pedido_pregao_data->domain()->saveAll($postData);
        $this->view->redirect("PedidoPregao", "edit", array('pregao_id' => $ret[0]->pregao_id));
    }

    function delete()
    {
        // $this->pregao_map_pregao_list->domain()->delete($this->view->dataGet()['id']);
        // $this->view->redirect("Pregao", "index");
    }
}

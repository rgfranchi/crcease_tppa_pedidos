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
        $this->loadBasicMapper("Pregao", "PregaoInfo");

        $this->loadBasicMapper('ItemPregao', 'PedidoItemPregaoList');
        $this->loadBasicMapper('ItemPregao', 'ItemPregaoUpdate');
        
        $this->loadBasicStores('PedidoPregao');

        $this->loadService(array('ItemPregaoCalculation'));
    }

    function index()
    {
        $this->view->setTitle("Pedido Pregão");
        $this->view->render("index", $this->pregao_map_pedido_pregao_list->component()->findAll());
    }
    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $pregao_itens = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        $pedidos = $this->pedido_pregao->findBy(["pregao_id", "==", $pregao_id]);

        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
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

        $data['pedido'] = $this->pedido_pregao->findBy(["pregao_id", "==", $pregao_id], ["hashCredito" => "DESC"]);
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
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
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;
        // Itens do pregão relacionado ao pedido.
        $itens_pregao = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        // Outros pedidos realizados exceto o atual.
        $pedidos = $this->pedido_pregao->findBy(
            [
                ["pregao_id", "==", $pregao_id],
                "AND",
                [ "_id","<>",$pedido_pregao_id]
            ]
        );
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['pedido'] = $pedido;
        // Calcula quantidade disponível.
        $data['itens'] = $this->item_pregao_calculation->disponiveis($itens_pregao, $pedidos);
        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);
    }
    /**
     * Altera o pedido do STATUS de solicitado até aprovado.
     */
    function edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;

        $data['status'] = $this->pedido_pregao->getDomain()->statusPedido("PEDIDO");
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedido'] = $this->item_pregao_calculation->solicitados($pedido);
        
        $this->view->setTitle("Pedido SOLICITADOS");
        $this->view->render("edit_solicitado", $data);
    }
    /**
     * Altera o pedido do STATUS de aprovados até empenhado.
     */
    function edit_aprovado() {
        $getPedido = $this->view->dataGet();
        $pregao_id = $getPedido['pregao_id'];
        $hashCredito = $getPedido['hash_credito'];
        $status = $this->pedido_pregao->getDomain()->statusPedido("CREDITO");
        $pedido = $this->pedido_pregao->findBy([
            ["pregao_id", "==", $pregao_id],
            "AND",
            ["status", "IN", $status],
            "AND",
            ["hashCredito", "==", $hashCredito]
        ]);
        $data['pedido_status'] = $getPedido['pedido_status'];
        $data['status'] = $status;
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedidos'] = $this->item_pregao_calculation->total_aprovados($pedido, $pregao_id);
        $data['hash_credito'] = $hashCredito;
        $this->view->setTitle("Pedidos APROVADOS");
        $this->view->render("edit_aprovado", $data);
    }


    function save()
    {
        $ret = $this->pedido_pregao->save($this->view->dataPost());
        $this->view->redirect("PedidoPregao", "edit", array('pregao_id' => $ret->pregao_id));
    }
    function saveMany()
    {
        $post = $this->view->dataPost();
        $idsPost = $post['_ids'];
        $statusPost = $post['status'];
        $hashCredito = $post['hash_credito'];
        $pregao_id = $post['pregao_id'];
        if(empty($hashCredito)) {
            $date = new DateTime();
            $hashCredito = $date->format('YmdHis');
        } 
        // desfaz a operação de Crédito
        if($statusPost === "APROVADO") {
            $hashCredito = "";
        }
        // desfaz a operação de Crédito
        if($statusPost === "EMPENHADO") {
            $pregao_itens = $this->item_pregao_map_item_pregao_update->component()->findBy(["pregao_id", "==", $pregao_id]);
            $pedidos = $this->pedido_pregao->findBy(
                ["_id", "IN", json_decode($idsPost)]
            );
            $new_pregao_itens = $this->item_pregao_calculation->disponiveis($pregao_itens, $pedidos);
            $ret = $this->item_pregao_map_item_pregao_update->domain()->saveAll($new_pregao_itens);
        }
        $postData = array();
        foreach(json_decode($idsPost) as $id) {
            $postData[] = array(
                "_id" =>  $id,
                "status" => $statusPost,
                "hashCredito" => $hashCredito
            );
        }
        $ret = $this->pedido_pregao->saveAll($postData);
        $this->view->redirect("PedidoPregao", "edit", array('pregao_id' => $ret[0]->pregao_id));
    }

    // function delete()
    // {
    //     // $this->pregao_map_pregao_list->domain()->delete($this->view->dataGet()['id']);
    //     // $this->view->redirect("Pregao", "index");
    // }
}

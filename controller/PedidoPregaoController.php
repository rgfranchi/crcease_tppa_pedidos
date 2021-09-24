<?php

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
        // $this->loadBasicMapper("Pregao", "PregaoListPedido");
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
        $data['pedido'] = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id]);
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
     * Altera o status do item.
     */
    function edit_status() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao_map_pedido_pregao_data->component()->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;
        $data['status'] = $this->pedido_pregao_map_pedido_pregao_data->getDomain()->statusPedido();
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedido'] = $this->item_pregao_calculation->solicitados($pedido);
        $this->view->setTitle("Pedido STATUS");
        $this->view->render("edit_status", $data);
    }

    function save()
    {
        $this->pedido_pregao_map_pedido_pregao_data->domain()->save($this->view->dataPost());
        $this->view->redirect("PedidoPregao", "index");
    }

    function delete()
    {
        // $this->pregao_map_pregao_list->domain()->delete($this->view->dataGet()['id']);
        // $this->view->redirect("Pregao", "index");
    }

    function pedido() {
        // $this->view->setTitle("Pedido Pregões");
        // $this->view->render("pedidos", $this->pregao_map_pregao_list_pedido->component()->findAll());
    }
}

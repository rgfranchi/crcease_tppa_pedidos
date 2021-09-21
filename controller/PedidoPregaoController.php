<?php

include 'BasicController.php';

class PedidoPregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('pedido_pregao');
        $this->loadBasicMapper('Pregao', 'PregaoHead');
        $this->loadBasicMapper('Pregao', 'PedidoPregaoList');
        $this->loadBasicMapper('PregaoItem', 'PedidoPregaoItemList','PregaoItem');
        
        $this->loadBasicMapper('PedidoPregao', 'PedidoPregaoData');
        $this->loadService(array(
            'PregaoItemCalculation'
        ));



        // $this->loadBasicMapper("Pregao", "PregaoForm");
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
        $pregao_itens = $this->pregao_item_map_pedido_pregao_item_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        $pedidos = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id]);
        $data['itens'] = $this->pregao_item_calculation->disponiveis($pregao_itens, $pedidos);
        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("itens_list", $data);
    }

    /**
     * Pregões disponíveis.
     */
    function consult()
    {
        $this->view->setTitle("Consultar Pedido (Pregão)");
        $this->view->render("consult", $this->pregao_map_pedido_pregao_list->component()->findAll());
    }

    /**
     * Pedidos realizados para o pregão.
     */
    function consult_pedido()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        // $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        // $pregao_itens = $this->pregao_item_map_pedido_pregao_item_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        $data = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id]);
        // $data['itens'] = $this->pregao_item_calculation->disponiveis($pregao_itens, $pedidos);
        $this->view->setTitle("Consultar Pedido");
        $this->view->render("consult_pedido", $data);
    }

    /**
     * Consultar itens solicitados.
     */
    function consult_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $data = $this->pedido_pregao_map_pedido_pregao_data->component()->findById($pedido_pregao_id);

carregar itens.

        // $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        // $pregao_itens = $this->pregao_item_map_pedido_pregao_item_list->component()->findBy(["pregao_id", "==", $pregao_id]);
        
        // $data['itens'] = $this->pregao_item_calculation->disponiveis($pregao_itens, $pedidos);

        pr($data); die;

        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("consult_pedido", $data);
    }



    function edit()
    {
        // $this->view->setTitle("Edita Pregão");
        // $this->view->render("form", $this->pregao_map_pregao_form->component()->findById($this->view->dataGet()['id']));
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

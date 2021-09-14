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



        // $this->loadBasicMapper("Pregao", "PregaoForm");
        // $this->loadBasicMapper("Pregao", "PregaoListPedido");
    }

    function index()
    {
        $this->view->setTitle("Pedido Pregão");
        $this->view->render("index", $this->pregao_map_pedido_pregao_list->component()->findAll());
    }

    function itens()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
       // $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
       // $data['itens'] = $this->pregao_item_map_pedido_pregao_item_list->component()->findByPregaoId($pregao_id);
        $pedidos = $this->pedido_pregao_map_pedido_pregao_data->component()->findBy(["pregao_id", "==", $pregao_id]);

        $itens_id = array();
        foreach($pedidos as $data) {
            foreach($data->itens_id as $key => $values) {
                $values = empty($values) ? 0 : $values;
                if(isset($itens_id[$key])) {
                    $itens_id[$key] += $values;
                } else {
                    $itens_id[$key] = $values;
                }
            }
        }
        pr($itens_id);



// calcular quantidade de itens solicitados.
        // $data['pedidos'] = $itens_id;


        pr($data);
        die;

        $this->view->setTitle("Pedido Pregão Itens");
        $this->view->render("itens_list", $data);
    }

    function add()
    {
        // $this->view->setTitle("Cadastra Pregão");
        // $this->view->render("form", $this->pregao_map_pregao_form->component()->emptyValues());
    }

    function edit()
    {
        // $this->view->setTitle("Edita Pregão");
        // $this->view->render("form", $this->pregao_map_pregao_form->component()->findById($this->view->dataGet()['id']));
    }

    function save()
    {
        $this->pedido_pregao_map_pedido_pregao_data->domain()->save($this->view->dataPost());
        $this->view->redirect("Pregao", "index");
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

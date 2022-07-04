<?php
namespace TPPA\APP\controller;

use TPPA\APP\component\DemandaFormComponent;
use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class PedidoDemandaController extends BasicController {

    function __construct()
    {
        $this->loadView('pedido_demanda');
        $this->loadBasicMapper('PedidoDemandaRepositorio', 'PedidoDemandaList');
        $this->loadBasicMapper('PedidoDemandaRepositorio', 'PedidoDemandaForm');
    }

    function index() {
        $get = $this->view->dataGet();
        $ret['pedidoDemanda'] = $this->pedido_demanda_repositorio_map_pedido_demanda_list->component()->findBy(["demanda_id", "==",$get['demanda_id']]);
        $ret['demanda_id'] = $get['demanda_id'];
        $this->view->render("index", $ret);
    }

    function add()
    {
        $get = $this->view->dataGet();
        $emptyDemandaRepositorio = $this->pedido_demanda_repositorio_map_pedido_demanda_form->component()->emptyValues();
        $emptyDemandaRepositorio->demanda_id = $get['demanda_id'];
        $this->view->setTitle("Criar Pedido Para Demanda");
        $this->view->render("form", $emptyDemandaRepositorio);
    }

    function update()
    {
        $this->view->setTitle("Atualizar Pedidos Demanda");
        $this->view->render("form", $this->pedido_demanda_repositorio_map_pedido_demanda_form->component()->findById($this->view->dataGet()["id"]));
    }

    function save() 
    {
        $post = $this->view->dataPost();
        $this->pedido_demanda_repositorio_map_pedido_demanda_list->domain()->save($post);
        $this->view->redirect("Demanda", "index");
    }

    function pedidoDemanda() {


    }
}

?>
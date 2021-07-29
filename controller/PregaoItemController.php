<?php

include 'BasicController.php';

class PregaoItemController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores('PregaoItem');
        $this->loadView('pregao_item');
        $this->loadMappper('PregaoItensToPregaoItemList');
    }

    function index()
    {
        $pregaoId = $this->view->dataGet()['pregao_id'];
        $res = $this->pregao_item->joinPregaoAndfindById($pregaoId);
        $this->pregao_itens_to_pregao_item_list->listItens($res);
        die;
        $this->view->render("index", $this->pregao_itens_to_pregao_item_list->getComponent());
    }
    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $this->view->setData(array('pregao_id' => $pregao_id));
        $this->view->render("form");
    }
    function edit()
    {
        $getId = $this->view->dataGet()['id'];
        $this->view->render("form", $this->pregao->findById($getId));
    }
    function save()
    {
        $post = $this->view->dataPost();
        $load_pregao = $this->pregao->findById($post['pregao_id']);
        $load_pregao->pregao_itens[] = $post;
        $this->pregao->save($load_pregao);
        $this->view->redirect('PregaoItens', "index");
    }
    function delete()
    {
        $id = $this->view->dataGet()['id'];
        $this->pregao->delete($id);
        $this->view->redirect('Pregao', "index");
    }
}

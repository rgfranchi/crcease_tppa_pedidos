<?php

include 'BasicController.php';

class PregaoItemController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadStores(array('Pregao', 'PregaoItem'));
        $this->loadView('pregao_item');
        $this->loadMapper('PregaoItemToPregaoItemList');
        $this->loadMapper('PregaoToPregaoItem');
        $this->loadMapper('PregaoItemToPregaoItemForm');
    }

    function index()
    {
        $pregaoId = $this->view->dataGet()['pregao_id'];
        $res = $this->pregao_item->joinPregaoAndFindById($pregaoId);

        $this->pregao_to_pregao_item->directComponent($res);
        $data['pregao'] = $this->pregao_to_pregao_item->getComponent();

        $this->pregao_item_to_pregao_item_list->directComponentList($res->itens);
        $data['itens'] = $this->pregao_item_to_pregao_item_list->getComponent();

        $this->view->setTitle("Lista Itens Pregões");

        $this->view->render("index", $data);
    }
    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $this->view->setData(array('pregao_id' => $pregao_id));

        $resp = $this->pregao->findById($pregao_id);

        $this->pregao_item_to_pregao_item_form->directComponent();
        $data['item'] = $this->pregao_item_to_pregao_item_form->getComponent();

        $this->pregao_to_pregao_item->directComponent($resp);
        $data['pregao'] = $this->pregao_to_pregao_item->getComponent();

        $this->view->setTitle("Cadastra Item para o pregão");

        $this->view->render("form", $data);
    }
    function edit()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $resp = $this->pregao_item->findPregaoByItemId($item_id);

        $this->pregao_item_to_pregao_item_form->directComponent($resp);
        $data['item'] = $this->pregao_item_to_pregao_item_form->getComponent();

        $this->pregao_to_pregao_item->directComponent($resp->pregao);
        $data['pregao'] = $this->pregao_to_pregao_item->getComponent();

        $this->view->setTitle("Atualiza Item para o pregão");

        $this->view->render("form", $data);
    }
    function save()
    {
        $post = $this->view->dataPost();
        $this->pregao_item->save($post);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $post['pregao_id']));
    }
    function delete()
    {
        $id = $this->view->dataGet()['item_id'];
        $item = $this->pregao_item->findById($id);
        $this->pregao_item->delete($id);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $item->pregao_id));
    }


    function upload_file() {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao->findById($pregao_id);

        include __ROOT__ . '/service/PhpSpreadsheetService.php';

        $loadFile = new PhpSpreadsheetService();
        $path = __ROOT__ . '/tests/arquivos/PE 13GAPSP2021.xls';
        $data['load_file'] = $loadFile->loadfile($path);

        $this->view->render("upload_file", $data);
    }

}

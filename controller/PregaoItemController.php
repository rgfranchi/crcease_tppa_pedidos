<?php

include 'BasicController.php';

class PregaoItemController extends BasicController
{
    function __construct()
    {

revisar pregão item .... 

        parent::__construct();
        $this->loadBasicStores('Pregao');
        $this->loadStores('PregaoItem');
        $this->loadView('pregao_item');

        $this->loadBasicMapper('Pregao','PregaoHead');
        $this->loadBasicMapper('PregaoItem','PregaoItemList');
        $this->loadBasicMapper('PregaoItem','PregaoItemForm');
        $this->loadMapper('PregaoItemMapPregaoItemFile');
        $this->loadService(array(
            'PhpSpreadsheet',
            // 'PregaoCalculation'
        ));
    }

    function index()
    {
        $pregaoId = $this->view->dataGet()['pregao_id'];
        
        $res = $this->pregao_item->joinPregaoAndFindById($pregaoId);

        $this->pregao_map_pregao_head->directComponent($res);
        $data['pregao'] = $this->pregao_map_pregao_head->getComponent();

        $this->pregao_item_map_pregao_item_list->directComponentList($res->itens);
        $data['itens'] = $this->pregao_item_map_pregao_item_list->getComponent();

        $this->view->setTitle("Lista Itens Pregões");

        $this->view->render("index", $data);
    }


    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $this->view->setData(array('pregao_id' => $pregao_id));

        $resp = $this->pregao->findById($pregao_id);

        $this->pregao_item_map_pregao_item_form->directComponent();
        $data['item'] = $this->pregao_item_map_pregao_item_form->getComponent();

        $this->pregao_map_pregao_head->directComponent($resp);
        $data['pregao'] = $this->pregao_map_pregao_head->getComponent();

        $this->view->setTitle("Cadastra Item para o pregão");

        $this->view->render("form", $data);
    }
    function edit()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $resp = $this->pregao_item->findPregaoByItemId($item_id);

        $this->pregao_item_map_pregao_item_form->directComponent($resp);
        $data['item'] = $this->pregao_item_map_pregao_item_form->getComponent();

        $this->pregao_map_pregao_head->directComponent($resp->pregao);
        $data['pregao'] = $this->pregao_map_pregao_head->getComponent();

        $this->view->setTitle("Atualiza Item para o pregão");

        $this->view->render("form", $data);
    }

    function save()
    {
        $post = $this->view->dataPost();
        $this->pregao_item_map_pregao_item_form->directDomain($post);
        $this->pregao_item->save($this->pregao_item_map_pregao_item_form->getDomain());
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $post['pregao_id']));
    }

    function delete()
    {
        $id = $this->view->dataGet()['item_id'];
        $item = $this->pregao_item->findById($id);
        $this->pregao_item->delete($item);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $item->pregao_id));
    }


    function upload_file()
    {
        $dataPost = $this->view->dataPost();
        if (empty($dataPost)) {
            $pregao_id = $this->view->dataGet()['pregao_id'];
        } else {
            $pregao_id = $dataPost['pregao_id'];
            $path = $_FILES['spreadsheet']['tmp_name'];
            $data['load_file'] = $this->php_spreadsheet->loadfile($path);
        }
        // // teste 
        // $path = __ROOT__ . '/tests/arquivos/PE 13GAPSP2021.xls';
        // $data['load_file'] = $this->php_spreadsheet->loadfile($path);
        // // fim teste
        $data['option_fields'] = $this->pregao_item_map_pregao_item_file->arrayOptionFields();

        $data['pregao'] = $this->pregao->findById($pregao_id);
        $this->view->render("upload_file", $data);
    }

    function file_save() {
        $post = $this->view->dataPost();
        $dataItens = $this->pregao_item_map_pregao_item_file->dataPregaoItem($post);
        $savedItens = $this->pregao_item->saveAll($dataItens);
        // pr($savedItens);
        // pr(json_encode($savedItens));
        // $objTest = '';
        // $savedItens = json_decode($objTest);
        // $this->pregao_calculation->sumListItemPregao($post['pregao_id'], $savedItens);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $post['pregao_id']));
    }



    
}

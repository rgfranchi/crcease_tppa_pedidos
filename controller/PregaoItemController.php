<?php

include 'BasicController.php';

class PregaoItemController extends BasicController
{
    function __construct()
    {
        $this->loadView('pregao_item');
        $this->loadBasicMapper('Pregao','PregaoHead');
        $this->loadBasicMapper('PregaoItem','PregaoItemList','PregaoItem');
        $this->loadBasicMapper('PregaoItem','PregaoItemForm','PregaoItem');

atualizar para arquivo.

        // $this->loadMapper('PregaoItemMapPregaoItemFile');
        // $this->loadService(array(
        //     'PhpSpreadsheet',
        //     // 'PregaoCalculation'
        // ));
    }

    function index()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['itens'] = $this->pregao_item_map_pregao_item_list->component()->findByPregaoId($pregao_id);
        $this->view->setTitle("Lista Itens Pregões");
        $this->view->render("index", $data);
    }


    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['item'] = $this->pregao_item_map_pregao_item_form->component()->emptyValues();
        $this->view->setTitle("Cadastra Item para o pregão");
        $this->view->render("form", $data);
    }
    function edit()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $data = $this->pregao_item_map_pregao_item_form->component()->findPregaoByItemId($item_id);
        $this->view->setTitle("Atualiza Item para o pregão");
        $this->view->render("form", $data);
    }

    function save()
    {
        $post = $this->view->dataPost();
        $this->pregao_item_map_pregao_item_form->domain()->save($post);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $post['pregao_id']));
    }

    function delete()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $del_item = $this->pregao_item_map_pregao_item_list->domain()->findById($item_id);
        $this->pregao_item_map_pregao_item_list->domain()->delete($del_item);
        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $del_item->pregao_id));
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

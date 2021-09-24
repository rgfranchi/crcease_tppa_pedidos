<?php

include 'BasicController.php';

class ItemPregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('item_pregao');
        $this->loadBasicMapper('Pregao','PregaoHead');
        $this->loadBasicMapper('ItemPregao','ItemPregaoList','ItemPregao');
        $this->loadBasicMapper('ItemPregao','ItemPregaoForm','ItemPregao');
        $this->loadMapper('ItemPregaoMapItemPregaoFile');
        $this->loadService(array(
            'PhpSpreadsheet',
        ));
    }

    function index()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['itens'] = $this->item_pregao_map_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $this->view->setTitle("Lista Itens Pregões");
        $this->view->render("index", $data);
    }


    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['item'] = $this->item_pregao_map_item_pregao_form->component()->emptyValues();
        $this->view->setTitle("Cadastra Item para o pregão");
        $this->view->render("form", $data);
    }
    function edit()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $data = $this->item_pregao_map_item_pregao_form->component()->findPregaoByItemId($item_id);
        $this->view->setTitle("Atualiza Item para o pregão");
        $this->view->render("form", $data);
    }

    function save()
    {
        $post = $this->view->dataPost();
        $this->item_pregao_map_item_pregao_form->domain()->save($post);
        $this->view->redirect('ItemPregao', "index", array('pregao_id' => $post['pregao_id']));
    }

    function delete()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $del_item = $this->item_pregao_map_item_pregao_list->domain()->findById($item_id);
        $this->item_pregao_map_item_pregao_list->domain()->delete($del_item);
        $this->view->redirect('ItemPregao', "index", array('pregao_id' => $del_item->pregao_id));
    }

    function delete_all()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $this->item_pregao_map_item_pregao_list->domain()->deleteAll($pregao_id);
        $this->view->redirect('ItemPregao', "index", array('pregao_id' => $pregao_id));
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
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        // inicio teste 
        // $path = __ROOT__ . '/tests/arquivos/PEDIDO_SEGURANCA_PE13_2021_ORIGEM.csv';
        // $data['load_file'] = $this->php_spreadsheet->loadfile($path);
        // fim teste
        $data['option_fields'] = $this->item_pregao_map_item_pregao_file->arrayOptionFields();
        $this->view->render("upload_file", $data);
    }

    function file_save() {
        $post = $this->view->dataPost();
        $this->item_pregao_map_item_pregao_file->saveAllItemPregao($post);
        // pr($savedItens);
        // pr(json_encode($savedItens));
        // $objTest = '';
        // $savedItens = json_decode($objTest);
        // $this->pregao_calculation->sumListItemPregao($post['pregao_id'], $savedItens);
        $this->view->redirect("ItemPregao", "index", array('pregao_id' => $post['pregao_id']));
    }

    function download_file()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $obj = $this->item_pregao_map_item_pregao_list->domain()->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $file_path = $this->php_spreadsheet->saveFile($obj, 'tmp_file');
        $this->view->download($file_path, "ItemPregao", "index", array('pregao_id' => $pregao_id));
    }
}

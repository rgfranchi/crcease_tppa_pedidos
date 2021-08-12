<?php

include 'BasicController.php';

class PregaoItemController extends BasicController
{
    function __construct()
    {
        parent::__construct();
        $this->loadBasicStores('Pregao');
        $this->loadStores('PregaoItem');
        $this->loadView('pregao_item');

        $this->loadBasicMapper('Pregao','PregaoItem');
        $this->loadBasicMapper('PregaoItem','PregaoItemList');
        
        // $this->loadMapper(array(
        //     'PregaoItemToPregaoItemList',
        //     'PregaoToPregaoItem',
        //     'PregaoItemToPregaoItemForm',
        //     'PregaoItemFormToPregaoItem',
        //     'PregaoItemToPregaoItemFile',
        //     'PregaoItemFileToPregaoItem',
        // ));
        $this->loadService(array(
            'PhpSpreadsheet',
            'PregaoCalculation'
        ));
    }

    function index()
    {
        $pregaoId = $this->view->dataGet()['pregao_id'];

        $res = $this->pregao_item->joinPregaoAndFindById($this->pregao, $pregaoId);

        $this->pregao_map_pregao_item->directComponent($res);
        $data['pregao'] = $this->pregao_map_pregao_item->getComponent();

        $this->pregao_item_map_pregao_item_list->directComponentList($res->itens);
        $data['itens'] = $this->pregao_item_map_pregao_item_list->getComponent();

        $this->view->setTitle("Lista Itens Pregões");

        $this->view->render("index", $data);
    }
    function add()
    {

continuar ajustes ..... 

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
        $post = $this->pregao_item_form_to_pregao_item->directComponent($this->view->dataPost());
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
        // teste 
        $path = __ROOT__ . '/tests/arquivos/PE 13GAPSP2021.xls';
        $data['load_file'] = $this->php_spreadsheet->loadfile($path);
        // fim teste
        $data['option_fields'] = $this->pregao_item_to_pregao_item_file->arrayOptionFields();

        $data['pregao'] = $this->pregao->findById($pregao_id);
        $this->view->render("upload_file", $data);
    }

    function file_save() {
        $post = $this->view->dataPost();
        $savedItens = $this->pregao_item->saveAll($this->pregao_item_file_to_pregao_item->dataPregaoItem($post));
        pr($savedItens);
        pr(json_encode($savedItens));
        
        die;

        $pregao = $this->pregao->findById($post['pregao_id']);

        // $savedItens = json_decode('');

        $this->pregao_calculation->setObjectPregao($pregao);
        $updatePregao = $this->pregao_calculation->sumListItemPregao($savedItens);

        pr($updatePregao);
        die;

        $this->view->redirect('PregaoItem', "index", array('pregao_id' => $post['pregao_id']));
    }



    
}

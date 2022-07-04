<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

// include 'BasicController.php';

class ItemPregaoController extends BasicController
{
    public $pregaoRepository = null;
    public $itemPregaoRepository = null;
    public $pedidoPregaoRepository = null;


    function __construct()
    {
        $this->loadView('item_pregao');
        $this->pregaoRepository = $this->loadRepository("Pregao");
        $this->itemPregaoRepository = $this->loadRepository("ItemPregao");
        $this->loadService(array('PhpSpreadsheet'));
    }

    function index()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
        $data['itens'] = $this->itemPregaoRepository->addQtd_disponivel($pregao_id);
        $this->view->setTitle("Lista Itens Pregões");
        $this->view->render("index", $data);
    }
    function download_index()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $obj = $this->itemPregaoRepository->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $file_path = $this->php_spreadsheet->saveFile($obj, 'pregao_itens');
        $this->view->download($file_path);
    }

    function add()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
        $data['item'] = $this->itemPregaoRepository->empty();
        $this->view->setTitle("Cadastra Item para o pregão");
        $this->view->render("form", $data);
    }
    function edit()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $data = $this->pregaoRepository->findPregaoByItemId($item_id);
        $this->view->setTitle("Atualiza Item para o pregão");
        $this->view->render("form", $data);
    }

    function save()
    {
        $post = $this->view->dataPost();
        $this->item_pregao->save($post);
        $this->view->redirect('ItemPregao', "index", array('pregao_id' => $post['pregao_id']));
    }

    function delete()
    {
        $item_id = $this->view->dataGet()['item_id'];
        $del_item = $this->itemPregaoRepository->findById($item_id);
        $this->itemPregaoRepository->delete($item_id);
        $this->view->redirect('ItemPregao', "index", array('pregao_id' => $del_item['pregao_id']));
    }

    function delete_all()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $this->itemPregaoRepository->deleteAll($pregao_id);
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
        $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
        $data['option_fields'] = $this->itemPregaoRepository->optionsFields();
        $this->view->render("upload_file", $data);
    }

    function file_save() {
        $post = $this->view->dataPost();
        $save_all = $this->item_pregao_file->executeFunction('convertToData',$post);
        $this->item_pregao->saveAll($save_all);
        $this->view->redirect("ItemPregao", "index", array('pregao_id' => $post['pregao_id']));
    }
}

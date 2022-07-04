<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

// include 'BasicController.php';

class PregaoController extends BasicController
{

    public $pregaoRepository = null;
    public $itemPregaoRepository = null;
    public $pedidoPregaoRepository = null;

    function __construct()
    {

        $this->loadView('pregao');
        $this->pregaoRepository = $this->loadRepository("Pregao");
        $this->itemPregaoRepository = $this->loadRepository("ItemPregao");
        $this->pedidoPregaoRepository = $this->loadRepository("PedidoPregao");
        
        $this->loadService(array("PhpSpreadsheet"));  

        // $this->storeDomain(["Pregao","ItemPregao", "PedidoPregao"]);
        // $this->mapperComponent("Pregao", "PregaoList");

        // // $this->loadBasicMapper("Pregao", "PregaoList");
        // $this->loadBasicMapper("Pregao", "PregaoForm");
      
    }

    function index()
    {
        $this->view->setTitle("Lista Pregões");
        $this->view->render("index", $this->pregaoRepository->findAll(['nome' => 'asc']));
        // $this->view->render("index", $this->pregao_list->findAll(['nome' => 'asc']));
    }

    function add()
    {
        $this->view->setTitle("Cadastra Pregão");
        $this->view->render("form", $this->pregaoRepository->empty());
    }

    function edit()
    {
        $this->view->setTitle("Edita Pregão");
        $this->view->render("form", $this->pregaoRepository->findById($this->view->dataGet()['id']));
    }

    function save()
    {
        $this->pregao->save($this->view->dataPost());
        $this->view->redirect("Pregao", "index");
    }

    function delete()
    {
        $exception = new ExceptionController("Falha ao excluir Pedido Pregão.");
        $pregao_id = $this->view->dataGet()['id'];
        $query = ['pregao_id','==',$pregao_id];
        $allItemPregao = $this->itemPregaoRepository->findBy($query);
        $allPedidoPregao = $this->pedidoPregaoRepository->findBy($query);

        foreach($allItemPregao as $val) {
            if($this->itemPregaoRepository->delete($val['_id']) !== true) {
                return $exception->delete("Falha ao excluir Item Pregão.");
            }
        }
        foreach($allPedidoPregao as $val) {
            if($this->pedidoPregaoRepository->delete($val['_id']) !== true) {
                return $exception->delete("Falha ao excluir Pedido Pregão.");
            }
        }
        $this->pregaoRepository->delete($pregao_id);
        $this->view->redirect("Pregao", "index");
    }

    function download_file()
    {
        $res = $this->pregaoRepository->findAll(['nome' => 'asc']);
        $file_path = $this->php_spreadsheet->saveFile($res, 'tmp_file');
        $this->view->download($file_path, "Pregao", "index");
    }

}

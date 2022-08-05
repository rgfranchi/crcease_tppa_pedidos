<?php
namespace TPPA\APP\controller;

use DateTime;
use TPPA\APP\service\PedidoPregaoService;
use TPPA\APP\domain\PedidoPregaoDomain;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

class PedidoPregaoController extends BasicController
{

    public $pregaoRepository = null;
    public $itemPregaoRepository = null;
    public $pedidoPregaoRepository = null; 

    function __construct()
    {
        $this->loadView('pedido_pregao');
        $this->pregaoRepository = $this->loadRepository("Pregao");
        $this->itemPregaoRepository = $this->loadRepository("ItemPregao");
        $this->pedidoPregaoRepository = $this->loadRepository("PedidoPregao");
        $this->loadService(array('PhpSpreadsheet'));
    }

    /**
     * 1 - Exibe os pregões ativos no sistema.
     */
    function index()
    {
        $this->view->setTitle("Pedido Pregão");
        $pregao = $this->pregaoRepository->joinPedidos();
        $pregao = $this->pregaoRepository->addQtd_pedidos($pregao);
        $pregao = $this->pregaoRepository->addData_vencimento_color($pregao);
        // $pregao = $this->pedidoPregaoRepository->addQtd_pedidos(); 
        $this->view->render("index", $pregao);
    }
    function download_index()
    {
        $pregao = $this->pregaoRepository->joinPedidos();
        $pregao = $this->pregaoRepository->addQtd_pedidos($pregao);     
        foreach($pregao as &$value) {
            unset($value['pedidos']);
        }
        $file_path = $this->php_spreadsheet->saveFile($pregao, 'pedido_pregao');
        $this->view->download($file_path);
    }    

    /**
     * 2 - Lista pedidos dispoíveis disponíveis.<br>
     * Permite editar o pedido ou criar novo pedido.
     */
    function edit_pedido()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregaoRepository->addData_vencimento_color(null, ['_id', '==', $pregao_id])[0];
        $findByPedido = [["pregao_id", "==", $pregao_id], ["status", "!=", "EXCLUIDO" ]];
        if(isset($_SESSION['login']['admin']) && $_SESSION['login']['admin'] == true) {
            $findByPedido = ["pregao_id", "==", $pregao_id];
        }
        $data['pedido'] = $this->pedidoPregaoRepository->findBy($findByPedido, ["create" => "DESC"]);
        $this->view->setTitle("Consultar Pedido");
        $this->view->render("edit_pedido", $data);
    }
    function download_edit_pedido()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $obj = $this->pedidoPregaoRepository->findBy(["pregao_id", "==", $pregao_id], ["hashCredito" => "DESC"]);
        foreach($obj as &$values) {
            unset($values['itens_pedido']);
        }
        $file_path = $this->php_spreadsheet->saveFile($obj, 'edit_pedido');
        $this->view->download($file_path);
    }    

    /**
     * 2.1 - Cria novo pedido
     */
    function add_itens()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
        $data['itens'] = $this->itemPregaoRepository->addQtd_disponivel($pregao_id);
        $data['pedido']['setor'] = $_SESSION['user']['setor'];   
        $data['pedido']['solicitante'] = $_SESSION['user']['nome'];
        $data['pedido']['status'] = "RASCUNHO";
        $this->view->setTitle("Criar Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);
    }

    /**
     * 2.2 - Editar pedido.
     */
    function edit_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $data['pedido'] = $pedido = $this->pedidoPregaoRepository->findById($pedido_pregao_id);
        $data['pregao'] = $this->pregaoRepository->findById($pedido['pregao_id']);
        $data['itens'] = $this->itemPregaoRepository->addQtd_disponivel($pedido['pregao_id'], $pedido_pregao_id);
        $this->view->setTitle("Atualizar Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);        
    }
    function download_edit_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedidoPregaoRepository->findById($pedido_pregao_id);
        $itens_pregao = $this->itemPregaoRepository->addQtd_disponivel($pedido['pregao_id'], $pedido_pregao_id);
        $newTotalPedido = array();
        foreach($itens_pregao as $value) {
            if(isset($pedido['itens_pedido'][$value['_id']])) {
                $value['qtd_solicitada'] = $pedido['itens_pedido'][$value['_id']];
                unset($value['qtd_disponivel']);
                $newTotalPedido[] = $value;
            } 
        }        
        $file_path = $this->php_spreadsheet->saveFile($newTotalPedido, 'edit_itens');
        $this->view->download($file_path);
    }

    /**
     * 3 - Altera o pedido do STATUS de solicitado até aprovado.
     */
    function edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedidoPregaoRepository->findById($pedido_pregao_id);
        $data['status'] = $this->pedidoPregaoRepository->statusPedido("PEDIDO");
        $data['pregao'] = $this->pregaoRepository->findById($pedido['pregao_id']);
        $data['pedido'] = $this->pedidoPregaoRepository->joinItemPregao(['_id','==',$pedido_pregao_id])[0];
        // verifica se já possui aprovador, se não utiliza o da seção.
        if(empty($data['pedido']['aprovador'])) {
            $data['pedido']['aprovador'] = $_SESSION['user']['nome'];
        }
        $this->view->setTitle("Pedido SOLICITADOS");
        $this->view->render("edit_solicitado", $data);
    }
    function download_edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        // $itens_calc = $this->pedidoPregaoRepository->solicitados($pedido_pregao_id);        
        $itens_calc = $this->pedidoPregaoRepository->joinItemPregao(['_id','==',$pedido_pregao_id])[0];        
        $obj = array();
        foreach($itens_calc['itens_pedido'] as $value) {
            $value['setor'] = $itens_calc['setor'];
            $value['solicitante'] = $itens_calc['solicitante'];
            $value['hashCredito'] = @$itens_calc['hashCredito'];
            $obj[] = $value;
        }
        $file_path = $this->php_spreadsheet->saveFile($obj, 'edit_solicitado');
        $this->view->download($file_path);
    }

    /**
     * 4 - Altera o pedido do STATUS de aprovados até empenhado.<br>
     * Contabiliza pedidos em tela com o status de APROVADO.
     */
    function edit_aprovado() {
        $getPedido = $this->view->dataGet();
        $pregao_id = $getPedido['pregao_id'];
        $hashCredito = $getPedido['hash_credito'];
        $data['pedido_status'] = $getPedido['pedido_status'];
        $data['status'] = $this->pedidoPregaoRepository->statusPedido("CREDITO");
        $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
        $data['pedidos'] = $this->pedidoPregaoRepository->totalAprovados($pregao_id, $hashCredito);
        $data['hash_credito'] = $hashCredito;  
        $this->view->setTitle("Pedidos APROVADOS");
        $this->view->render("edit_aprovado", $data);
    }
    function download_edit_aprovado()
    {
        $get = $this->view->dataGet();
        $export = $this->pedidoPregaoRepository->totalAprovados($get['pregao_id'], $get['hash_credito']);
        $pedidoPregaoService = new PedidoPregaoService();
        $export = $pedidoPregaoService->inLineTotalAprovados($export);
        $file_path = $this->php_spreadsheet->saveFile($export, 'edit_aprovado');
        $this->view->download($file_path, "Pregao", "index");
    }


    /**
     * Salva itens (cria ou atualiza)
     */
    function update_status()
    {
        $post = $this->view->dataPost();
        if($post['status'] === "RASCUNHO") {
             $post['aprovador'] = '';
        }
        $ret = $this->pedidoPregaoRepository->save($post);
        $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret['pregao_id']));
    }


    /**
     * Salva itens (cria ou atualiza)
     */
    function save()
    {
        $post = $this->view->dataPost();
        if($post['status'] === "RASCUNHO") {
             $post['aprovador'] = '';
        }
        $pregao_id = $post['pregao_id'];
        // $itens_pregao = $this->itemPregaoRepository->findBy(["pregao_id", "==", $pregao_id]);
        // $pedido_pregao_id = isset($post['_id']) ? $post['_id'] : null;
        $validatePedido = $this->pedidoPregaoRepository->validatePedido($post);
        // verifica se pedido é valido
        if(empty($validatePedido['invalid_itens'])) {
            $ret = $this->pedidoPregaoRepository->save($post);
            $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret['pregao_id']));
        } else {
            $data['pregao'] = $this->pregaoRepository->findById($pregao_id);
            $data['pedido'] = $post;
            // Calcula quantidade disponível.
            $data['itens'] = $validatePedido['item_pregao_disponiveis'];
            $data['invalid_itens'] = $validatePedido['invalid_itens'];

            $this->view->setTitle("Corrigir Pedido Pregão Itens");
            $this->view->render("edit_itens", $data);
        }
    }

    function saveMany()
    {
        $post = $this->view->dataPost();
//        $pregao_id = $post['pregao_id'];
        $hashCredito = $post['hash_credito'];
        
        $idsPost = $post['_ids'];
        $statusPost = $post['status'];
        if(empty($hashCredito)) {
            $date = new DateTime();
            $hashCredito = $date->format('YmdHis');
        } 
        // desfaz a operação de Crédito
        if($statusPost === "APROVADO") {
            $hashCredito = "";
        }
        if($statusPost === "AGUARDANDO APROVAÇÃO") {
            $hashCredito = "";
        }
        $postData = array();

        foreach(json_decode($idsPost) as $id) {
            $postData[] = array(
                "_id" =>  $id,
                "status" => $statusPost,
                "hashCredito" => $hashCredito
            );
        }
        $ret = $this->pedidoPregaoRepository->saveAll($postData);
        $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret[0]['pregao_id']));
    }

    function delete()
    {
        $basicFunctions = new BasicFunctions();
        $get = $this->view->dataGet();
        if($get['pedido_status'] === "EMPENHADO" && isset($get['pedido_status'])) {
            $basicFunctions->loadException("PEDIDO NÃO PODE SER EXCLUÍDO");
        }
        $this->pedidoPregaoRepository->disableAfterRead(true);
        $pedido = $this->pedidoPregaoRepository->findById($get['pedido_pregao_id']);
        $pedido['status'] = "EXCLUIDO";    
        $ret = $this->pedidoPregaoRepository->save($pedido);
        $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret['pregao_id']));
    }
}

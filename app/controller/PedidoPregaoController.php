<?php
namespace TPPA\APP\controller;

use DateTime;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\controller\BasicController;

// include 'BasicController.php';

class PedidoPregaoController extends BasicController
{
    function __construct()
    {
        $this->loadView('pedido_pregao');
        
        $this->loadBasicMapper('Pregao', 'PregaoHead');
        $this->loadBasicMapper('Pregao', 'PedidoPregaoList');
        $this->loadBasicMapper("Pregao", "PregaoInfo");

        $this->loadBasicMapper('ItemPregao', 'PedidoItemPregaoList');
        $this->loadBasicMapper('ItemPregao', 'ItemPregaoUpdate');
        
        $this->loadBasicStores('PedidoPregao');

        $this->loadService(array('PhpSpreadsheet','ItemPregaoCalculation'));
    }

    function index()
    {
        $this->view->setTitle("Pedido Pregão");
        $this->view->render("index", $this->pregao_map_pedido_pregao_list->component()->findBy(["ativo", "==", "true"]));
    }
    function download_index()
    {
        $obj = $this->loadBasicStores("Pregao")->findBy(["ativo", "==", "true"]);
        $file_path = $this->php_spreadsheet->saveFile($obj, 'pedido_pregao');
        $this->view->download($file_path);
    }    

    /**
     * Pregões disponíveis.
     */
    function edit_pedido()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        
        $findByPedido = [["pregao_id", "==", $pregao_id], ["status", "!=", "EXCLUIDO" ]];
        if(isset($_SESSION['login']['admin']) && $_SESSION['login']['admin'] == true) {
            $findByPedido = ["pregao_id", "==", $pregao_id];
        }

        $data['pedido'] = $this->pedido_pregao->findBy($findByPedido, ["hashCredito" => "DESC"]);
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $this->view->setTitle("Consultar Pedido");
        $this->view->render("edit_pedido", $data);
    }
    function download_edit_pedido()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $obj = $this->pedido_pregao->findBy(["pregao_id", "==", $pregao_id], ["hashCredito" => "DESC"]);

        foreach($obj as &$values) {
            unset($values->itens_pedido);
        }
        $file_path = $this->php_spreadsheet->saveFile($obj, 'tmp_file');
        $this->view->download($file_path);
    }    

    function add_itens()
    {
        $pregao_id = $this->view->dataGet()['pregao_id'];
        $item_pregao = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $pedidos = $this->pedido_pregao->findBy(["pregao_id", "==", $pregao_id]);

        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['itens'] = $this->item_pregao_calculation->disponiveis($item_pregao, $pedidos);
        $this->view->setTitle("Criar Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);
    }

    /**
     * Consultar itens solicitados.
     */
    function edit_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        // Pedido selecionado.
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;
        // Itens do pregão relacionado ao pedido.
        $itens_pregao = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        // Outros pedidos realizados exceto o atual.
        $pedidos = $this->pedido_pregao->findBy(
            [
                ["pregao_id", "==", $pregao_id],
                "AND",
                [ "_id","<>",$pedido_pregao_id]
            ]
        );
        $data['pregao'] = $this->pregao_map_pregao_head->component()->findById($pregao_id);
        $data['pedido'] = $pedido;
        // Calcula quantidade disponível.
        $data['itens'] = $this->item_pregao_calculation->disponiveis($itens_pregao, $pedidos);
        $this->view->setTitle("Atualizar Pedido Pregão Itens");
        $this->view->render("edit_itens", $data);
    }
    function download_edit_itens()
    {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;
        // Itens do pregão relacionado ao pedido.
        $itens_pregao = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $pregao_id],['cod_item_pregao' => 'asc']);
        $newTotalPedido = array();
        foreach($itens_pregao as $value) {
            if(isset($pedido->itens_pedido[$value->_id])) {
                $value->qtd_solicitada = $pedido->itens_pedido[$value->_id];
                unset($value->qtd_disponivel);
                $newTotalPedido[] = $value;
            } 
        }
        $file_path = $this->php_spreadsheet->saveFile($newTotalPedido, 'edit_itens');
        $this->view->download($file_path);
    }

    /**
     * Altera o pedido do STATUS de solicitado até aprovado.
     */
    function edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $pregao_id = $pedido->pregao_id;

        $data['status'] = $this->pedido_pregao->getDomain()->statusPedido("PEDIDO");
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedido'] = $this->item_pregao_calculation->solicitados($pedido);
        
        $this->view->setTitle("Pedido SOLICITADOS");
        $this->view->render("edit_solicitado", $data);
    }
    function download_edit_solicitado() {
        $pedido_pregao_id = $this->view->dataGet()['pedido_pregao_id'];
        $pedido = $this->pedido_pregao->findById($pedido_pregao_id);
        $itens_calc = $this->item_pregao_calculation->solicitados($pedido);
        $obj = array();
        foreach($itens_calc->itens_pedido as $value) {
            $value->setor = $itens_calc->setor;
            $value->solicitante = $itens_calc->solicitante;
            $value->hashCredito = $itens_calc->hashCredito;
            $obj[] = $value;
        }
        $file_path = $this->php_spreadsheet->saveFile($obj, 'edit_solicitado');
        $this->view->download($file_path);
    }

    /**
     * Altera o pedido do STATUS de aprovados até empenhado.<br>
     * Contabiliza pedidos em tela com o status de APROVADO.
     */
    function edit_aprovado() {
        $getPedido = $this->view->dataGet();
        $pregao_id = $getPedido['pregao_id'];
        $hashCredito = $getPedido['hash_credito'];
        $status = $this->pedido_pregao->getDomain()->statusPedido("CREDITO");
        $pedido = $this->pedido_pregao->findBy([
            ["pregao_id", "==", $pregao_id],
            "AND",
            ["status", "IN", $status],
            "AND",
            ["hashCredito", "==", $hashCredito]
        ]);
        $data['pedido_status'] = $getPedido['pedido_status'];
        $data['status'] = $status;
        $data['pregao'] = $this->pregao_map_pregao_info->component()->findById($pregao_id);
        $data['pedidos'] = $this->item_pregao_calculation->total_aprovados($pedido, $pregao_id);
        $data['hash_credito'] = $hashCredito;
        $this->view->setTitle("Pedidos APROVADOS");
        $this->view->render("edit_aprovado", $data);
    }
    function download_edit_aprovado()
    {
        $basicFunctions = new BasicFunctions();
        $get = $this->view->dataGet();
        $pedidos = $this->pedido_pregao->findBy([
            ["pregao_id", "==", $get['pregao_id']],
            "AND",
            ["hashCredito", "==", $get['hash_credito']]
        ]);
        $itens_pregao = $this->item_pregao_map_pedido_item_pregao_list->component()->findBy(["pregao_id", "==", $get['pregao_id']]);
        foreach($pedidos as $pedido) {
            $param = $pedido->setor . '-' . $pedido->solicitante. '(' . $pedido->status . ')';
            foreach($itens_pregao as &$values) {
                if(isset($pedido->itens_pedido[$values->_id])) {
                    isset($values->sub_total) ? 
                        $values->sub_total += $basicFunctions->convertCommaToDot($values->valor_unitario) * $pedido->itens_pedido[$values->_id] :
                        $values->sub_total = $basicFunctions->convertCommaToDot($values->valor_unitario) * $pedido->itens_pedido[$values->_id];
                    isset($values->total) ? 
                        $values->total += $pedido->itens_pedido[$values->_id] :
                        $values->total = $pedido->itens_pedido[$values->_id];
                    $values->{$param} = $pedido->itens_pedido[$values->_id];
                } else {
                    $values->{$param} = 0;
                }
            }
        }
        $file_path = $this->php_spreadsheet->saveFile($itens_pregao, 'edit_aprovado');
        $this->view->download($file_path, "Pregao", "index");
    }

    function save()
    {
        $post = $this->view->dataPost();
        $pregao_id = $post['pregao_id'];
        // busca valores existentes
        $itens_pregao = $this->item_pregao_map_pedido_item_pregao_list->domain()->findBy(["pregao_id", "==", $pregao_id]);
        $pedido_pregao_id = isset($post['_id']) ? $post['_id'] : 0;
        $pedidos = $this->pedido_pregao->findBy(
            [
                ["pregao_id", "==", $pregao_id],
                "AND",
                [ "_id","<>",$pedido_pregao_id]
            ]
        );

        // verifica disponibilidade.
        $this->item_pregao_calculation->disponiveis($itens_pregao, array_merge($pedidos,array( 'NEW_ITEM' => (Object) $post)));

        $invalid = $this->item_pregao_calculation->getInvalidItem();

        // verifica se pedido é valido
        if(empty($invalid)) {
            $ret = $this->pedido_pregao->save($post);
            $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret->pregao_id));
        } else {
            $data['pregao'] = $this->pregao_map_pregao_head->domain()->findById($pregao_id);
            $data['pedido'] = (Object) $post;
            // Calcula quantidade disponível.
            $data['itens'] = $this->item_pregao_calculation->disponiveis($itens_pregao, $pedidos);
            $data['invalid_itens'] = $invalid;

            $this->view->setTitle("Corrigir Pedido Pregão Itens");
            $this->view->render("edit_itens", $data);
        }
    }

    function saveMany()
    {
        $post = $this->view->dataPost();
        $idsPost = $post['_ids'];
        $statusPost = $post['status'];
        $hashCredito = $post['hash_credito'];
        $pregao_id = $post['pregao_id'];
        if(empty($hashCredito)) {
            $date = new DateTime();
            $hashCredito = $date->format('YmdHis');
        } 
        // desfaz a operação de Crédito
        if($statusPost === "APROVADO") {
            $hashCredito = "";
        }
        if($statusPost === "EMPENHADO") {
            $pregao_itens = $this->item_pregao_map_item_pregao_update->component()->findBy(["pregao_id", "==", $pregao_id]);
            $pedidos = $this->pedido_pregao->findBy(
                ["_id", "IN", json_decode($idsPost)]
            );
            $new_pregao_itens = $this->item_pregao_calculation->disponiveis($pregao_itens, $pedidos);
            $ret = $this->item_pregao_map_item_pregao_update->domain()->saveAll($new_pregao_itens);
        }
        $postData = array();
        foreach(json_decode($idsPost) as $id) {
            $postData[] = array(
                "_id" =>  $id,
                "status" => $statusPost,
                "hashCredito" => $hashCredito
            );
        }
        $ret = $this->pedido_pregao->saveAll($postData);
        $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret[0]->pregao_id));
    }

    function delete()
    {
        $get = $this->view->dataGet();

        if($get['pedido_status'] === "EMPENHADO" && isset($get['pedido_status'])) {
            loadException("PEDIDO NÃO PODE SER EXCLUÍDO");
        }


        $pedido = $this->pedido_pregao->findById($get['pedido_pregao_id']);
        
        $pedido->status = "EXCLUIDO";    
        $ret = $this->pedido_pregao->save((array) $pedido);

        $this->view->redirect("PedidoPregao", "edit_pedido", array('pregao_id' => $ret->pregao_id));
    }
}

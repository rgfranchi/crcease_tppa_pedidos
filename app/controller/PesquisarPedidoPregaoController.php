<?php
namespace TPPA\APP\controller;

use TPPA\CORE\controller\BasicController;

use function TPPA\CORE\basic\pr;

// include 'BasicController.php';

class PesquisarPedidoPregaoController extends BasicController
{

    function __construct()
    {
        $this->loadView('pesquisar_pedido_pregao');
        $this->pregaoRepository = $this->loadRepository("Pregao");
        // $this->pedidoPregaoRepository = $this->loadRepository("PedidoPregao");
        // $this->loadService("PedidoPregaoPesquisar");
    }

    /**
     * Busca pelo texto em "find_value" (POST) no campos.
     * PregaoDomain - nome / objeto / termo_referencia_origem / numero_processo_PAG
     * ItemPregaoDomain - cod_item_pregao / nome / descricao / fornecedor
     * PedidoPregaoDomain - setor / solicitante / status
     */
    function index() 
    {
        $data = $this->view->dataPost();
        $data['find_value'] = isset($data['find_value']) ? $data['find_value'] : "";
        $data['ativo'] = isset($data['ativo']) ? $data['ativo'] : "true";

        $where_pregao = ['ativo', '==', $data['ativo']];

        $data['pregao'] = $this->pregaoRepository->findPregao($data['find_value'], $where_pregao);
        $data['item_pregao'] = $this->pregaoRepository->findItemPregao($data['find_value'],$where_pregao);
        $data['item_pregao'] = $this->pregaoRepository->findPedidoPregao($data['find_value'],$where_pregao);

        $this->view->render("index",$data);
    }
}
?>
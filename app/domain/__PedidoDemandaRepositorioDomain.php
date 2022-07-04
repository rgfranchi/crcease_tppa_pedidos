<?php
namespace TPPA\APP\domain;


use TPPA\APP\component\helper\ParseFunctions;
use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

// include_once('BasicDomain.php');

class PedidoDemandaRepositorioDomain extends BasicDomain {
    public $_id;
    public $nome;
    public $descricao;
    public $observacao;
    public $ativo;
    public $demanda_id;
    Public $pedidoRepositorio;
}

class PedidoRepositorio {
    public $observacao;
    public $valor;
    public $fontePesquisa;
    public $repositorio_id;
}

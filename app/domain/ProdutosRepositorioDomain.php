<?php
namespace TPPA\APP\domain;

use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

// include_once('BasicDomain.php');

class ProdutosRepositorioDomain extends BasicDomain implements iBasicDomain {
    public $nome;
    public $descricao;
    public $tags;
    public $aplicacao;
    public $catmat;
    public $continuado;
    public $media_consumo_ano;
    public $observacao;
}
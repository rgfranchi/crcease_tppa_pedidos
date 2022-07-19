<?php
namespace TPPA\APP\domain;

use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

/**
 * Classe filha de NecessidadeDomain
 * Utilizada para manter a fila de NecessidadeDomain.
 */
class NecessidadeItemDomain {
    public $cod_item;
    public $nome;
    public $descricao;
    public $requisicao_minima;
    public $requisicao_maxima;
    public $valor_medio;
    public $numero_catalogo;
    public $justificativa_quantidade;
}
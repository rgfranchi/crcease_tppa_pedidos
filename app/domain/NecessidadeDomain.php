<?php
namespace TPPA\APP\domain;

use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

use function TPPA\CORE\basic\pr;

// include_once('BasicDomain.php');

class NecessidadeDomain extends BasicDomain {
    public $_id;
    public $nome;
    public $objeto;
    public $justificativa_necessidade;
    // LOG
    public $projeto;
    public $integrante_tecnico;
    public $integrante_requisitante;
    public $ativo;
    public $observacao;
    // Lista de itens solicitados.
    // NecessidadeItensDomain
    public $necessidade_itens;


    function beforeSave($data)
    {
        pr("Inserir necessidade_itens ordenado.");

        if(!isset($data["necessidade_itens"])) {
            $data["necessidade_itens"] = [];
        }

        return $data;
    }

}
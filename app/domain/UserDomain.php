<?php
namespace TPPA\APP\domain;

use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

// include_once('BasicDomain.php');

class UserDomain extends BasicDomain {
    public $_id;
    public $login;
    public $nome;
    public $password;
    public $setor;
    public $grupo;
    public $ativo;
    public $tipo_cadastro;
    public $observacao;
}
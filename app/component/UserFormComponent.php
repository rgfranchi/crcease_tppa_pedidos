<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\PregaoHelper;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

// include_once('BasicComponent.php');

class UserFormComponent extends BasicComponent
{
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
 
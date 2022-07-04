<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\PregaoHelper;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

// include_once('BasicComponent.php');

class DemandaListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $descricao;
    public $natureza_despesa;
    public $natureza; // Projeto ou Atividade.
}
 
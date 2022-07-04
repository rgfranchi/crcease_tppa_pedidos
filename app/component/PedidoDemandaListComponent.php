<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\CORE\BasicFunctions;
use TPPA\CORE\component\BasicComponent;

// include_once('BasicComponent.php');
// include_once('helper/ItemPregaoHelper.php');

class PedidoDemandaListComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $descricao;
    public $observacao;
    public $demanda_id;
}
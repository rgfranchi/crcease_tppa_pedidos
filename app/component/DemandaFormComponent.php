<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\CORE\component\BasicComponent;
// include_once('helper/ItemPregaoHelper.php');

class DemandaFormComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $descricao;
    /**
     * 33.90.30 - Material de Consumo
     * 33.90.39 - Outros Serviços de Terceiros - Pessoa Jurídica
     * 44.90.52 - Equipamentos e Material Permanente – incorporando ao patrimônio
     * 44.90.40 - Serviços de Tecnologia da Informação e Comunicação – Pessoa Jurídica"
     * 33.90.40 - Comunicação de Dados
    */    
    public $natureza_despesa;
    public $natureza; // Projeto ou Atividade.
    public $observacao;
    public $ativo;
}

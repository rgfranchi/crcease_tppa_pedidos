<?php
namespace TPPA\APP\component;

use TPPA\APP\component\helper\ItemPregaoHelper;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once('helper/ItemPregaoHelper.php');

class DemandaFormComponent extends BasicComponent
{
    public $_id;
    public $nome;
    public $descricao;
    public $natureza_despesa;
    public $natureza; // Projeto ou Atividade.
    public $observacao;
    public $filtro_repositorio;
    public $filtro_natureza_despesa;
    public $ativo;

    /**
     * Aplicar para classe instanciada a conversão do campo.
     */
    function convertFieldRead($name, $value, &$newObject) {
        switch($name) {
            case 'filtro_repositorio' :
                $value = implode(";",$value);
                break;
        }      
        $newObject->{$name} = $value;
    }
    /**
     * Aplicar validação de conversão do campo.
     * @return boolean true (valido) false (invalido)
     */
    function validateField($name, $value) {
        return true;
    }  


}

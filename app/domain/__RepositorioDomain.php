<?php
namespace TPPA\APP\domain;


use TPPA\APP\component\helper\ParseFunctions;
use TPPA\CORE\domain\BasicDomain;
use TPPA\CORE\domain\iBasicDomain;

// include_once('BasicDomain.php');

class RepositorioDomain extends BasicDomain {
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
    // vinculo com Demanda
    public $tags;
    public $aplicacao;
    public $catmat;
    public $continuado;
    public $media_consumo_ano;
    public $observacao;

    function convertFieldRead($name, $value, &$newObject){
        $parseFunctions = new ParseFunctions();
        switch($name) {
            case 'natureza_despesa' :
                $value = $parseFunctions->convertNaturezaDespesa($value);
                break;
        }
        parent::convertFieldRead($name, $value, $newObject);
    }

}
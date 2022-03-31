<?php
namespace TPPA\APP\domain;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\domain\BasicDomain;
// include_once('BasicDomain.php');

class ItemPregaoDomain extends BasicDomain
{
    public $_id;
    public $cod_item_pregao; // código do item no PE.
    public $descricao;
    public $valor_unitario;
    public $valor_solicitado;
    public $qtd_total;
    // public $qtd_disponivel; // qtd disponível -> campo calculado.
    // public $qtd_solicitada; // quantidade solicitada do PE
    public $unidade; // unidade de medida.
    public $fornecedor; // fornecedor do item
    public $qtd_minima; 
    /**
     * 33.90.30 - Material de Consumo
     * 33.90.39 - Outros Serviços de Terceiros - Pessoa Jurídica
     * 44.90.52 - Equipamentos e Material Permanente – incorporando ao patrimônio
     * 44.90.40 - Serviços de Tecnologia da Informação e Comunicação – Pessoa Jurídica"
     * 33.90.40 - Comunicação de Dados
    */
    public $natureza_despesa;  

    // id do Objeto Pregoes.php
    public $pregao_id;

    function convertField($name, $value, &$newObject){
        $basicFunction = new BasicFunctions();
        switch($name) {
            case 'valor_unitario' :
                if(is_null($value)) break;
            case 'valor_solicitado' :
                $value = $basicFunction->convertCommaToDot($value);
                break;
            case 'natureza_despesa' :
                $value = $this->convertNaturezaDespesa($value);
                break;
        }
        parent::convertField($name, $value, $newObject);
    }

    function convertNaturezaDespesa($value) {
        $value = strtolower($value);
        if($value == '30' || (strpos($value, 'material') && strpos($value, 'consumo')) || $value == '339030') {
            $value = '33.90.30';
        }
        if($value == '39' || strpos($value, 'serviços') || strpos($value, 'servicos') || $value == '339039') {
            $value = '33.90.39';
        }
        if($value == '52' || (strpos($value, 'material') && strpos($value, 'permanente')) || $value == '449052') {
            $value = '44.90.52';
        }
        if($value == '40' || $value == '449040') {
            $value = '44.90.40';
        }
        if($value == '339040') {
            $value = '33.90.40';
        }
        return $value;
    }

    function validateField($name, $value)
    {
        $basicFunction = new BasicFunctions();
        $validate = true;
        switch($name) {
            case 'valor_unitario' :
                if($validate = !is_null($value)) 
                break;
            case 'valor_solicitado' :
                $validate = is_numeric($value);
                break;
            case 'cod_item_pregao' :
            // case 'qtd_disponivel' :
            case 'descricao' :
                $validate = !is_null($value);
                break;
        }
        if(!$validate) {
            $basicFunction->loadException("Campo '$name' com valor '$value' inválido");
        } 
    }

    /**
     * Verifica a existência das quantidades total e disponível.<br>
     * Se uma ausente copia da outra, considera subtrair a quantidade solicitada.
     */
    // function beforeSave($data)
    // {
    //     if(is_null($data['qtd_total']) && !is_null($data['qtd_disponivel'])) {
    //         $data['qtd_total'] = $data['qtd_disponivel'] + $data['qtd_solicitada'];
    //     }
    //     if(is_null($data['qtd_disponivel']) && !is_null($data['qtd_total'])) {
    //         $data['qtd_disponivel'] = $data['qtd_total'] - $data['qtd_solicitada'];
    //     }
    //     return $data;
    // }
}

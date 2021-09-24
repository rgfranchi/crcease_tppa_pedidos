<?php

include_once('BasicDomain.php');

class ItemPregaoDomain extends BasicDomain
{
    public $_id;
    public $cod_item_pregao; // código do item no PE.
    public $nome; 
    public $descricao;
    public $valor_unitario;
    public $valor_solicitado;
    public $qtd_total;
    public $qtd_disponivel; // qtd disponível para solicitação
    public $qtd_solicitada; // quantidade solicitada do PE
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


    function convertField($name, $value){
        switch($name) {
            case 'valor_unitario' :
                if(is_null($value)) break;
            case 'valor_solicitado' :
                $value = convertCommaToDot($value);
                break;
        }
        
        return $value;
    }

    function validateField($name, $value)
    {
        $validate = true;
        switch($name) {
            case 'valor_unitario' :
                if($validate = !is_null($value)) break;
            case 'valor_solicitado' :
                $validate = is_numeric($value);
                break;
            case 'cod_item_pregao' :
            case 'qtd_disponivel' :
            case 'nome' :
                $validate = !is_null($value);
                break;
        }
        if(!$validate) {
            loadException("Campo '$name' com valor '$value' inválido");
        } 
    }

    function beforeSave($data)
    {
        if(is_null($data['qtd_total']) && !is_null($data['qtd_disponivel'])) {
            $data['qtd_total'] = $data['qtd_disponivel'] + $data['qtd_solicitada'];
        }
        if(is_null($data['qtd_disponivel']) && !is_null($data['qtd_total'])) {
            $data['qtd_disponivel'] = $data['qtd_total'] - $data['qtd_solicitada'];
        }
        return $data;
    }
}

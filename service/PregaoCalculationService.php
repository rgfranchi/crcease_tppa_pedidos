<?php

require_once(__ROOT__ . '/config.php');

class PregaoCalculationService extends BasicSystem {
    
    private $objectPregao = null;

    function __construct()
    {
        $this->loadBasicStores('Pregao');
    }

    /**
     * Soma lista de itens ao pregão.
     */
    function sumListItemPregao($pregao_id, $listItem) {
        $this->objectPregao = $this->pregao->findById($pregao_id);
        foreach($listItem as $value) {
            $this->sumPregao($value);
        }
        $this->pregao->save((array) $this->objectPregao);
    }

    /**
     * Soma um único item do pregão
     */
    function sumItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->sumPregao($item);
        $this->pregao->save((array) $this->objectPregao);
    }

    /**
     * Subtrai um único item do pregão
     */
    function subtractItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->subtractPregao($item);
        $this->pregao->save((array) $this->objectPregao);
    }

    /**
     * Atualiza um único item do pregão
     */
    function updateItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->subtractPregao($item);
        $this->sumPregao($item);
        $this->pregao->save((array) $this->objectPregao);
    }


    /**
     * Soma respectivamente:
     * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
     * Pregao     qtd_total, qtd_disponivel, valor_total
     */
    function sumPregao($item) {
        if(empty($this->objectPregao)) {
            loadException("'objectPregao' não definido");
        }
        $this->objectPregao->valor_total += (convertCommaToDot($item->valor_unitario) * $item->qtd_total);
        $this->objectPregao->qtd_total += $item->qtd_total;
        $this->objectPregao->qtd_disponivel += $item->qtd_disponivel;
    }

    /**
     * Subtrai respectivamente:
     * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
     * Pregao     qtd_total, qtd_disponivel, valor_total
     */
    function subtractPregao($item) {
        if(empty($this->objectPregao)) {
            loadException("Pregão não definido incluir 'setPregao(pregao)'");
        }
        $this->objectPregao->valor_total -= (convertCommaToDot($item->valor_unitario) * $item->qtd_total);
        $this->objectPregao->qtd_total -= $item->qtd_total;
        $this->objectPregao->qtd_disponivel -= $item->qtd_disponivel;
    }

    // /**
    //  * Soma valores e retorna em $valueAdd
    //  */
    // function sumFloat(&$valueAdd, $value) {
    //     $value = convertCommaToDot($value);
    //     $valueAdd = convertCommaToDot($valueAdd);
    //     $valueAdd += $value;
    // }

    // /**
    //  * Subtrai valores e retorna em $valueSubtract
    //  */    
    // function subtractMoneyFloat(&$valueSubtract, $value) {
    //     $value = convertCommaToDot($value);
    //     $valueSubtract = convertCommaToDot($valueSubtract);
    //     $valueSubtract -= $value;
    //     $valueSubtract = convertToMoneyBR($valueSubtract);
    // }


}
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
        $this->pregao->save($this->objectPregao);
    }

    /**
     * Soma um único item do pregão
     */
    function sumItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->sumPregao($item);
        $this->pregao->save($this->objectPregao);
    }

    /**
     * Subtrai um único item do pregão
     */
    function subtractItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->subtractPregao($item);
        $this->pregao->save($this->objectPregao);
    }

    /**
     * Atualiza um único item do pregão
     */
    function updateItemPregao($item) {
        $this->objectPregao = $this->pregao->findById($item->pregao_id);
        $this->subtractPregao($item);
        $this->sumPregao($item);
        $this->pregao->save($this->objectPregao);
    }


    /**
     * Soma respectivamente:
     * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
     * Pregao     qtd_total, qtd_disponivel, valor_total
     */
    function sumPregao($item) {
        if(empty($this->objectPregao)) {
            throw new Exception("'objectPregao' não definido");
        }
        $valorTotalItem = convertCommaToDot($item->valor_unitario) * $item->qtd_total;
        $this->sumMoneyFloat($this->objectPregao->valor_total, $valorTotalItem);
        $this->objectPregao->qtd_total += $item->qtd_total;
        $this->objectPregao->qtd_disponivel += $item->qtd_total;
    }

    /**
     * Subtrai respectivamente:
     * PregaoItem qtd_total, qtd_disponivel, (valor_unitario * qtd_total) com 
     * Pregao     qtd_total, qtd_disponivel, valor_total
     */
    function subtractPregao($item) {
        if(empty($this->objectPregao)) {
            throw new Exception("Pregão não definido incluir 'setPregao(pregao)'");
        }
        $valorTotalItem = convertCommaToDot($item->valor_unitario) * $item->qtd_total;
        $this->subtractMoneyFloat($this->objectPregao->valor_total, $valorTotalItem);
        $this->objectPregao->qtd_total -= $item->qtd_total;
        $this->objectPregao->qtd_disponivel -= $item->qtd_total;
    }

    /**
     * Soma valores e retorna em $valueAdd
     */
    function sumMoneyFloat(&$valueAdd, $value) {
        $value = convertCommaToDot($value);
        $valueAdd = convertCommaToDot($valueAdd);
        $valueAdd += $value;
        $valueAdd = convertToMoneyBR($valueAdd);
    }

    /**
     * Subtrai valores e retorna em $valueSubtract
     */    
    function subtractMoneyFloat(&$valueSubtract, $value) {
        $value = convertCommaToDot($value);
        $valueSubtract = convertCommaToDot($valueSubtract);
        $valueSubtract -= $value;
        $valueSubtract = convertToMoneyBR($valueSubtract);
    }


}
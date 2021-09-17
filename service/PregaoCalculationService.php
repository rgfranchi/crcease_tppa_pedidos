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
     * Zera valor dos itens do pregão.
     */
    function resetItensPregao($pregao_id) {
        $this->objectPregao = $this->pregao->findById($pregao_id);
        $this->objectPregao->valor_total = 0.0;
        $this->objectPregao->qtd_total = 0;
        $this->objectPregao->qtd_disponivel = 0;
        $this->objectPregao->valor_solicitado = 0;
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
        if($item->qtd_disponivel > 0) {
            $this->objectPregao->qtd_disponivel += $item->qtd_disponivel;
        } else {
            $this->objectPregao->qtd_disponivel += $item->qtd_total;
        }
        if($item->qtd_solicitada > 0) {
            $this->objectPregao->valor_solicitado += ($item->qtd_solicitada * $item->valor_unitario);
        } else {
            $this->objectPregao->valor_solicitado += $item->valor_solicitado;
        }
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
        if($item->qtd_disponivel > 0) {
            $this->objectPregao->qtd_disponivel -= $item->qtd_disponivel;
        } else {
            $this->objectPregao->qtd_disponivel -= $item->qtd_total;
        }        
        $this->objectPregao->valor_solicitado -= ($item->qtd_solicitada * $item->valor_unitario);
    }
}
<?php
class PregaoCalculationService {
    
    private $objectPregao = null;

    function setObjectPregao($objectPregao) {
        $this->objectPregao = $objectPregao;
    }


    function sumListItemPregao($listItem) {
        foreach($listItem as $value) {
            $this->sumItemPregao($value);
        }
        pr("fim sum list");
    }


    function sumItemPregao($item) {

        if(empty($this->objectPregao)) {
            throw new Exception("Pregão não definido incluir 'setPregao(pregao)'");
        }
        pr($item);
        pr($this->objectPregao);

        $this->objectPregao->qtd_total += $item->qtd_total;
        var_dump(floatval($item->valor_unitario));
        $this->objectPregao->valor_total += $item->valor_unitario;

        pr($this->objectPregao);

        die;
        // somar quantidade Total
        // somar valor total
    }

    function subtractItemPregao() {
        // subtrai quantidade total
        // subtrai valor total
    }
}
<?php
namespace TPPA\APP\component;
use TPPA\CORE\component\BasicComponent;

use function TPPA\CORE\basic\pr;

// include_once(__CORE__.'/component/BasicComponent.php');

class DashboardIndexComponent extends BasicComponent
{
    public $status = [];
    public $quantidade = [];
    public $cores = [];
    public $total = 0;


    function loadIndex($store) {
        $data = $store->findAll();

        $qtdStatus = array(
            "RASCUNHO" => 0, // Pedido Criado. 
            "AGUARDANDO APROVAÇÃO" => 0, // Verificando disponibilidades de valores.
            "APROVADO" => 0, // Gestores da meta
            "CREDITO SOLICITADO" => 0, // Registrada a Solicitação de Crédito ("SIGA")
            "CREDITADO" => 0, // Crédito Recebido (Nota de Credito)
            "EMPENHO SOLICITADO" => 0, // Criada a Solicitação (SREQ SILOMS). 
            "EMPENHADO" => 0, // Empenho recebido (Valor é subtraído do ItemPregão)
        );

        $this->total = 0;
        foreach($data as $value) {
            if(isset($qtdStatus[$value['status']])) {
                $qtdStatus[$value['status']]++;
            }
            $this->total++;
        }

        $this->cores = array(
            "#f6c23e",
            "#ac872b",
            "#36b9cc",
            "#25818e",
            "#206f7a",
            "#10373d",
            "#1cc88a",
        );



        $this->status = array_keys($qtdStatus);
        $this->quantidade = array_values($qtdStatus);

        return $this;
    }



}

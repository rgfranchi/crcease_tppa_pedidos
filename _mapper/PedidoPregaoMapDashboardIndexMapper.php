<?php

include_once 'BasicMapper.php';

class PedidoPregaoMapDashboardIndexMapper extends BasicMapper
{
    /**
     * @param string nome da classe filha 
     * @param string domainName -> dominio do objeto 
     */
    function __construct()
    {
        parent::__construct("PedidoPregao", "DashboardIndex");
    }

    function loadIndex() {

        $data = $this->pedido_pregao->findAll();

        $qtdStatus = array(
            "SOLICITADO" => 0, // Pedido Criado. 
            "AGUARDANDO APROVAÇÃO" => 0, // Verificando disponibilidades de valores.
            "APROVADO" => 0, // Gestores da meta
            "CREDITO SOLICITADO" => 0, // Registrada a Solicitação de Crédito ("SIGA")
            "CREDITADO" => 0, // Crédito Recebido (Nota de Credito)
            "EMPENHO SOLICITADO" => 0, // Criada a Solicitação (SREQ SILOMS). 
            "EMPENHADO" => 0, // Empenho recebido (Valor é subtraido do ItemPregão)
        );

        $this->dashboard_index->total = 0;
        foreach($data as $value) {

            if(isset($qtdStatus[$value->status])) {
                $qtdStatus[$value->status]++;
            }

            $this->dashboard_index->total++;
        }

        $this->dashboard_index->cores = array(
            "#f6c23e",
            "#ac872b",
            "#36b9cc",
            "#25818e",
            "#206f7a",
            "#10373d",
            "#1cc88a",
        );



        $this->dashboard_index->status = array_keys($qtdStatus);
        $this->dashboard_index->quantidade = array_values($qtdStatus);

        return $this->dashboard_index;
    }

}

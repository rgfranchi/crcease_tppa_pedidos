<?php
namespace TPPA\APP\repository;

use TPPA\CORE\BasicFunctions;
use TPPA\CORE\repository\BasicRepository;

use function TPPA\CORE\basic\pr;

class PedidoPregaoRepository extends BasicRepository
{
    function __construct() {
        parent::__construct("PedidoPregao");
    }

    /**
     * Responde com o status de acordo com as etapas do processo.
     * @param $etapa ('PEDIDO' (Default) ou 'CREDITO' ) -> etapa do sistema de acesso.
     */
    function statusPedido($etapa = "PEDIDO") {
        // mater a chave com valor crescente para controle por comparação. > ou <
        $status = array(
            0 => "RASCUNHO", // Pedido Criado. 
            1 => "AGUARDANDO APROVAÇÃO", // Verificando disponibilidades de valores.
            2 => "APROVADO", // Gestores da meta
            3 => "CREDITO SOLICITADO", // Registrada a Solicitação de Crédito ("SIGA")
            4 => "CREDITADO", // Crédito Recebido (Nota de Credito)
            5 => "EMPENHO SOLICITADO", // Criada a Solicitação (SREQ SILOMS). 
            6 => "EMPENHADO" // Empenho recebido (Valor é subtraido do ItemPregão)
        );

        switch($etapa) {
            case "PEDIDO" : 
                $status = array_slice($status,0,3);
                break;
            case "CREDITO" :
                $status = array_slice( $status, 2);
                break;
        }
        return $status;
    }

    /**
     * Realiza a junção do PedidoPregao com ItemPregao.
     * Campo 'itens_pedido' subquery substitui array numerico por itens do pedidos.
     *      - utiliza '$itemPregaoRepository->addQtd_disponivel' para incluir campo 'diponíveis'.
     *      - Para cada item é incluida as colunas 'qtd_solicitada' e 'valor_solicitado'.
     * Campo 'total_pedido' é composto pelos valores 'quantidade' e 'valor' com o total POR 'pedido'.
     * Campo 'qtd_total' e 'valor_total' realiza a soma de todos os pedidos localizados.
     * 
     * @param $conditions_pedido condição da subquery de pedidos. 
     * @param $conditions_item condição de restrição do item. 
     * @return $pedidos realizados por item.
     */    
    function joinItemPregao($conditions_pedido = [], $conditions_item = []) {
        $query_pedido = empty($conditions_pedido) ? ['_id','>','0'] : $conditions_pedido;
        $itemPregaoRepository = new ItemPregaoRepository();
        $basicFunctions = new BasicFunctions();

        $qtd_total = 0;
        $valor_total = 0;

        $qtd_total_pedido = 0;
        $valor_total_pedido = 0;
        $pedido_pregao = $this->getStore()
            ->createQueryBuilder()
            ->where($query_pedido)
            ->join(function($pedido) use ($itemPregaoRepository, $conditions_item, &$qtd_total_pedido, &$valor_total_pedido, &$qtd_total, &$valor_total, $basicFunctions)  {
                $qtd_total_pedido = 0;
                $valor_total_pedido = 0;
                $itens_id = array_keys($pedido['itens_pedido']);
                $query_itens = ['_id','IN',$itens_id];
                if(!empty($conditions_item)) {
                    $query_itens = array_merge(
                        [$query_itens], $conditions_item
                    );
                } 
                $itemPregaoRepository->disableAfterRead(true);

                $itens_pedido = $itemPregaoRepository->addQtd_disponivel($pedido['pregao_id'], $query_itens, false);
                foreach ($itens_pedido as &$value) {
                    $iten_id = $value['_id'];
                    $quantidade = $pedido['itens_pedido'][$iten_id];
                    // soma quantidades
                    if(!is_numeric($quantidade)) {
                        $quantidade = 0;
                    }
                    $qtd_total_pedido += $value['qtd_solicitada'] = $quantidade;
                    $qtd_total += $value['qtd_solicitada'] = $quantidade;

                    // soma valores
                    $valor_solicitado = $value['valor_unitario'] * $quantidade;
                    $value['valor_solicitado'] = $basicFunctions->convertToMoneyBR($valor_solicitado);
                    $valor_total_pedido += $valor_solicitado;
                    $valor_total += $valor_solicitado;
                    $value = $itemPregaoRepository->getDomain()->afterRead($value);
                }
                return $itens_pedido;
            }, 'itens_pedido')
            ->join(function($pedido) use (&$qtd_total_pedido, &$valor_total_pedido, $basicFunctions)  {
                return ['quantidade' => $qtd_total_pedido,'valor'=> $basicFunctions->convertToMoneyBR($valor_total_pedido)];
            }, 'total_pedido')
            ->getQuery()
            ->fetch();
            $pedido_pregao['qtd_total'] = $qtd_total;
            $pedido_pregao['valor_total'] = $basicFunctions->convertToMoneyBR($valor_total);
            return $pedido_pregao;
    }

    /**
     * Soma a quantidades pedidos por item.<br>
     * Acrescenta campos 'sub_total_valor', 'sub_total_quantidade' por pedido.<br>
     * Acrescenta no array 'total_valor', 'total_quantidade' e 'pedidos_ids[]'.
     * @param $itens_pregao itens do objeto pregão
     * @param $pedidos itens pedidos do pregão.
     */
    function totalAprovados($pregao_id, $hash_credito) {
        $itemPregaoRepository = new ItemPregaoRepository();
        $status = $this->statusPedido("CREDITO");
        $header = array(
                    'cod_item_pregao' => "COD",
                    'descricao' => "DESCRIÇÃO",
                    'valor_unitario' => "VALOR UNITARIO",
                    'fornecedor' => "FORNECEDOR",
                    'sub_total_valor' => 'SUB TOTAL (R$)',
                    'sub_total_quantidade' => 'SUB TOTAL (UN)',
                );
        $pedidos_item_pregao = $itemPregaoRepository->joinsPedidos(
            [
                ["status", "IN", $status],
                ["hashCredito", "==", $hash_credito]
            ], 
            ["pregao_id", "==", $pregao_id] 
        );
        $total_valor = 0.0;
        $total_quantidade = 0;    
        $pedidos_ids = [];
        $header_pedidos = [];
        foreach($pedidos_item_pregao as $item_key => &$item) {
            // informações do item.
            $pedido_quantidade_total = 0.0;
            if(empty($item['pedidos'])) {
                unset($pedidos_item_pregao[$item_key]);
                continue;
            }
            // leitura dos pedidos.
            foreach($item['pedidos'] as $key => $pedido) {
                // título com nome do pedido.
                $pedido_quantidade_total += $pedido['quantidade'];
                $pedidos_ids[$pedido['_id']] = 1;
                $header_pedidos['_'.$key] = array( // convert chave em string para manter no HEADER
                   'setor' => $pedido['setor'],
                   'status' => $pedido['status'],
                   'solicitante' => $pedido['solicitante']
                );
            }
            $total_valor += $item['sub_total_valor'] = $item['valor_unitario'] * $pedido_quantidade_total;
            $total_quantidade += $item['sub_total_quantidade'] = $pedido_quantidade_total;
        }   
        ksort($header_pedidos);

        $pedidos_item_pregao['total_valor'] = $total_valor;
        $pedidos_item_pregao['total_quantidade'] = $total_quantidade;
        $pedidos_item_pregao['pedidos_ids'] = array_keys($pedidos_ids);
        $res['BODY'] = $pedidos_item_pregao;
        $res['HEADER'] = array_merge($header,$header_pedidos);
        return $res;
    }    

    function dashboard() {
        $data = $this->findAll();
        $qtdStatus = array(
            "RASCUNHO" => 0, // Pedido Criado. 
            "AGUARDANDO APROVAÇÃO" => 0, // Verificando disponibilidades de valores.
            "APROVADO" => 0, // Gestores da meta
            "CREDITO SOLICITADO" => 0, // Registrada a Solicitação de Crédito ("SIGA")
            "CREDITADO" => 0, // Crédito Recebido (Nota de Credito)
            "EMPENHO SOLICITADO" => 0, // Criada a Solicitação (SREQ SILOMS). 
            "EMPENHADO" => 0, // Empenho recebido (Valor é subtraído do ItemPregão)
        );

        $total = 0;
        foreach($data as $value) {
            if(isset($qtdStatus[$value['status']])) {
                $qtdStatus[$value['status']]++;
            }
            $total++;
        }

        $ret = [
            'total' => $total,
            'cores' => array(
                "#f6c23e",
                "#ac872b",
                "#36b9cc",
                "#25818e",
                "#206f7a",
                "#10373d",
                "#1cc88a",
            ), 
            'status' => array_keys($qtdStatus),
            'quantidade' => array_values($qtdStatus)
            ];
        return $ret;
    }


    /**
     * Verifica se os itens solicitado está disponível. <br>
     * Se: invalid_itens não for empty() possui valores com quantidades inválidas. 
     * @return ['item_pregao_disponiveis' => $itens_disponiveis, 'invalid_itens' => []]
     */
    function validatePedido($pedidoPregao) {
        $itemPregaoRepository = new ItemPregaoRepository();
        // busca a quantidade de itens diponíveis.
        $itens_disponiveis = $itemPregaoRepository->addQtd_disponivel($pedidoPregao['pregao_id'], @$pedidoPregao['_id']);
        // Apenas valores diferentes de zero.
        $itens_pedido = array_filter($pedidoPregao['itens_pedido']);
        $ret = [
            'item_pregao_disponiveis' => $itens_disponiveis,
            'invalid_itens' => [],
        ];
        foreach($itens_pedido as $key => $value) {
            $iten_validade = $itens_disponiveis[array_search($key, array_column($itens_disponiveis, '_id'))];
            if($iten_validade['qtd_disponivel'] < $value) {
                $ret['invalid_itens'][] = $iten_validade;
            }
        }
        return $ret;
    }
}
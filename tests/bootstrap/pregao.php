<?php

$id = 0;
$pregao_delete = new BasicStore('PregaoStore','Pregao');
$pregao_delete->getStore()->deleteStore();

$pregao_store = new BasicStore('PregaoStore','Pregao');

pr($pregao_store);

$pregoes_1 = new PregaoDomain();
$pregoes_1->_id = ++$id;
$pregoes_1->nome = "51/GAPSP/2020";
$pregoes_1->objeto = "Aquisição de Material de Pintura.";
$pregoes_1->termo_referencia_origem = "21/TPPA/2020";
// $pregoes_1->valor_total = 0.0;
// $pregoes_1->valor_solicitado = 0.0;
// $pregoes_1->qtd_total = 0;
// $pregoes_1->qtd_disponivel = 0;
$pregoes_1->data_homologacao = '2020-12-23';
$pregoes_1->data_limite_solicitacao = '2021-12-23';
$pregoes_1->numero_processo_PAG = "67267003628202069";
$pregoes_1->url_proposta = "comprasnet.gov.br/livre/Pregao/anexosPropostaHabilitacao.asp?prgCod=902635";
$pregoes_1->url_anexo= "http://comprasnet.gov.br/livre/Pregao/anexosDosItens.asp?uasg=120633&numprp=512020&prgcod=860295";
$pregoes_1->url_siasg_net = "https://www2.comprasnet.gov.br/siasgnet-atasrp/public/pesquisarItemSRP.do?method=iniciar&parametro.identificacaoCompra.numeroUasg=120633&parametro.identificacaoCompra.modalidadeCompra=5&parametro.identificacaoCompra.numeroCompra=00051&parametro.identificacaoCompra.anoCompra=2020";
$pregoes_1->ativo = "true";

pr($pregoes_1);
$pregao_store->create_update_object((array) $pregoes_1);

$pregoes_2 = new PregaoDomain();
$pregoes_2->_id = ++$id;
$pregoes_2->nome = "82/GAPSP/2020";
$pregoes_2->objeto = "Aquisição de Material Permanente de Climatização com Instalação para o Serviço Regional de Proteção ao Voo de São Paulo e Destacamentos Subordinados, conforme condições, quantidades e exigências estabelecidas neste instrumento.";
$pregoes_2->termo_referencia_origem = "21/TPPA/2021";
// $pregoes_2->valor_total = 40000.00;
// $pregoes_2->valor_solicitado = 0;
// $pregoes_2->qtd_total = 1;
// $pregoes_2->qtd_disponivel = 1;
// $pregoes_2->data_vencimento = '2021-10-29';
$pregoes_2->data_homologacao = '2020-11-30';
$pregoes_2->data_limite_solicitacao = '2021-12-30';
$pregoes_2->numero_processo_PAG = "67617016410201913";
$pregoes_2->url_proposta = "http://comprasnet.gov.br/livre/Pregao/anexosPropostaHabilitacao.asp?prgCod=877391";
$pregoes_2->url_anexo= "http://comprasnet.gov.br/livre/Pregao/anexosDosItens.asp?uasg=120633&numprp=822020&prgcod=877391";
$pregoes_2->url_siasg_net = "https://www2.comprasnet.gov.br/siasgnet-atasrp/public/pesquisarItemSRP.do?method=iniciar&parametro.identificacaoCompra.numeroUasg=120633&parametro.identificacaoCompra.modalidadeCompra=5&parametro.identificacaoCompra.numeroCompra=00082&parametro.identificacaoCompra.anoCompra=2020";
$pregoes_2->ativo = "true";

pr($pregoes_2);
$pregao_store->create_update_object((array) $pregoes_2);

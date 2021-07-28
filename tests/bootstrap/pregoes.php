<?

include_once $app_path . '/store/PregaoStore.php';

$pregao_store = new PregaoStore();

$pregoes_1 = new Pregoes();
$pregoes_1->_id = 1;
$pregoes_1->nome = "85/GAP/2020";
$pregoes_1->objeto = "Aquisição com instalação de Ar condicionado para o CRCEA-SE.";
$pregoes_1->termo_referência_origem = "20/TPPA/2021";
$pregoes_1->url_proposta = "comprasnet.gov.br/livre/Pregao/anexosPropostaHabilitacao.asp?prgCod=902635";
$pregoes_1->objeto = "Contratação de serviço, de natureza continuada, SEM necessidade de dedicação exclusiva de mão de obra, para a prestação de serviços de recolhimento de resíduos para o HOSPITAL CENTRAL DA AERONÁUTICA HCA e Hospital de Força Aérea do Galeão - HFAG";
$pregoes_1->valor_total = '100.000,00';
$pregoes_1->valor_solicitado = '20.000,00';
$pregoes_1->qtd_total = 1000;
$pregoes_1->qtd_solicitada = 180;
$pregoes_1->qtd_disponivel = 820;
$pregoes_1->data_homologacao = '2020-10-30';

pr($pregoes_1);

$pregao_store->update($pregoes_1);

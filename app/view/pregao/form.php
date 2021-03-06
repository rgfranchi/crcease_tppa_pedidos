<?php
use TPPA\CORE\BasicFunctions;
use function TPPA\CORE\basic\pr;
$basicFunctions = new BasicFunctions();
?>
<form action="<?= $this->action("Pregao", "save"); ?>" method="post">
    <?php if ($this->data['_id'] > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data['_id'] ?>"><br>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nome">Pregão:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data['nome'] ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome do Pregão numero/unidade/ano.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="numero_processo_PAG">Número do Processo (PAG):</label>
                <input type="text" id="numero_processo_PAG" name="numero_processo_PAG" class="form-control" aria-describedby="numero_processo_PAGHelp" value="<?= $this->data['numero_processo_PAG'] ?>">
                <small id="numero_processo_PAGHelp" class="form-text text-muted">Numero Localizado na ATA com 17 digitos.</small>
            </div>
        </div>        
        <div class="col">
            <div class="form-group">
                <label for="data_homologacao">Data Homologação:</label>
                <input type="date" id="data_homologacao" name="data_homologacao" class="form-control" aria-describedby="data_homologacaoHelp" value="<?= $basicFunctions->convertToDateTimeSystem($this->data['data_homologacao'], false) ?>">
                <small id="data_homologacaoHelp" class="form-text text-muted">Data Descrição em 'Termo de Homologação'.</small>
            </div>
        </div>        
        <div class="col">
            <div class="form-group">
                <label for="data_limite_solicitacao">Data Limite Solicitação:</label>
                <input type="date" id="data_limite_solicitacao" name="data_limite_solicitacao" class="form-control" aria-describedby="data_limite_solicitacaoHelp" value="<?= $basicFunctions->convertToDateTimeSystem($this->data['data_limite_solicitacao'], false) ?>">
                <small id="data_limite_solicitacaoHelp" class="form-text text-muted">Data limite para realizar solicitação do pregão.</small>
            </div>
        </div>   
        <div class="col">
            <div class="form-group">
                <label for="ativo">Ativo:</label>
                <select id="ativo" name="ativo" class="form-control" aria-describedby="ativoHelp">
                    <option <?= $this->data['ativo'] == "true" ? "selected" : "" ?> value="true" >SIM</option>
                    <option <?= $this->data['ativo'] == "false" ? "selected" : "" ?> value="false">NÃO</option>
                </select>
                <small id="ativoHelp" class="form-text text-muted">Ativo ou inativo.</small>
            </div>
        </div>             
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="termo_referencia_origem">Termo de Referência / TOD:</label>
                <input type="text" id="termo_referencia_origem" name="termo_referencia_origem" class="form-control" aria-describedby="termo_referencia_origemHelp" value="<?= $this->data['termo_referencia_origem'] ?>">
                <small id="termo_referencia_origemHelp" class="form-text text-muted">Termo de Referência do processo.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="url_proposta">URL Propostas:</label>
                <input type="text" id="url_proposta" name="url_proposta" class="form-control" aria-describedby="url_propostaHelp" value="<?= $this->data['url_proposta'] ?>">
                <small id="url_propostaHelp" class="form-text text-muted">'Anexo de Proposta' <a href="http://comprasnet.gov.br/acesso.asp?url=/livre/Pregao/ata0.asp" target="_blank">COMPRAS NET</a>.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="url_anexo">URL Anexo:</label>
                <input type="text" id="url_anexo" name="url_anexo" class="form-control" aria-describedby="url_anexoHelp" value="<?= $this->data['url_anexo'] ?>">
                <small id="url_anexoHelp" class="form-text text-muted">'Anexo dos Itens'.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="url_siasg_net">URL SIASG NET:</label>
                <input type="text" id="url_siasg_net" name="url_siasg_net" class="form-control" aria-describedby="url_siasg_netHelp" value="<?= $this->data['url_siasg_net'] ?>">
                <small id="url_siasg_netHelp" class="form-text text-muted">URL Após consulta <a href="https://www2.comprasnet.gov.br/siasgnet-atasrp/public/principal.do" target="_blank">ATA SRP</a>.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="objeto">Objeto:</label>
                <textarea class="form-control" id="objeto" name="objeto" class="form-control" aria-describedby="objetoHelp" rows="5"><?= $this->data['objeto'] ?></textarea>
                <small id="objetoHelp" class="form-text text-muted">Descrição do objeto inserida na ATA de Registro de Preço.</small>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar"><span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
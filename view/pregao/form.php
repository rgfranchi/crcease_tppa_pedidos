<form action="<?= $this->action("Pregao", "save"); ?>" method="post">
    <?php if ($this->data->_id > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data->_id ?>"><br>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nome">Pregão:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data->nome ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome do Pregão numero/unidade/ano.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="valor_total">Valor Total:</label>
                <input type="text" id="valor_total" name="valor_total" class="form-control money" aria-describedby="valor_totalHelp" value="<?= $this->data->valor_total ?>">
                <small id="valor_totalHelp" class="form-text text-muted">Soma Valores dos itens ofertados, calculado ao inserir itens.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_total">Quantidade Total:</label>
                <input type="number" id="qtd_total" name="qtd_total" class="form-control" aria-describedby="qtd_totalHelp" value="<?= $this->data->qtd_total ?>">
                <small id="qtd_totalHelp" class="form-text text-muted">Quantidade total de itens do pregão, calculado ao inserir itens.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="termo_referência_origem">Termo de Referência / TOD:</label>
                <input type="text" id="termo_referência_origem" name="valor_solicitado" class="form-control" aria-describedby="termo_referência_origemHelp" value="<?= $this->data->termo_referência_origem ?>">
                <small id="termo_referência_origemHelp" class="form-text text-muted">Termo de Referência do processo.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="valor_solicitado">Valor Solicitado:</label>
                <input type="text" id="valor_solicitado" name="valor_solicitado" class="form-control money" aria-describedby="valor_solicitadoHelp" value="<?= $this->data->valor_solicitado ?>">
                <small id="valor_solicitadoHelp" class="form-text text-muted">Valor Total dos pedidos realizados, é calculado a cada pedido encerrado.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_disponivel">Quantidade Disponível:</label>
                <input type="number" id="qtd_disponivel" name="qtd_disponivel" class="form-control" aria-describedby="qtd_disponivelHelp" value="<?= $this->data->qtd_disponivel ?>">
                <small id="qtd_disponivelHelp" class="form-text text-muted">Quantidade de itens disponíveis.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="qtd_disponivel">URL Propostas:</label>
                <input type="text" id="url_proposta" name="url_proposta" class="form-control" aria-describedby="url_propostaHelp" value="<?= $this->data->url_proposta ?>">
                <small id="url_propostaHelp" class="form-text text-muted">URL de 'Anexo de Proposta' <a href="http://comprasnet.gov.br/acesso.asp?url=/livre/Pregao/ata0.asp" target="_blank">COMPRAS NET</a>.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="data_homologacao">Data Homologação:</label>
                <input type="date" id="data_homologacao" name="data_homologacao" class="form-control" aria-describedby="data_homologacaoHelp" value="<?= $this->data->data_homologacao ?>">
                <small id="data_homologacaoHelp" class="form-text text-muted">Data de homologação do Pregão, vencimento após um ano.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="objeto">Objeto:</label>
                <textarea class="form-control" id="objeto" name="objeto" class="form-control" aria-describedby="objetoHelp" rows="5"><?= $this->data->objeto ?></textarea>
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
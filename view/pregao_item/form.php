<?php include_once 'pregao_item.php'; ?>
<form action="<?= $this->action("PregaoItem", "save"); ?>" method="post">
    <?php if ($this->data['item']->_id > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data['item']->_id ?>">
    <?php endif; ?>
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data['item']->nome ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome do Item.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="valor_unitario">Valor Unitário:</label>
                <input type="text" id="valor_unitario" name="valor_unitario" class="form-control money" aria-describedby="valor_unitarioHelp" value="<?= $this->data['item']->valor_unitario ?>">
                <small id="valor_unitarioHelp" class="form-text text-muted">Valor unitário vencedor.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="valor_solicitado">Valor Solicitado:</label>
                <input type="text" id="valor_solicitado" name="valor_solicitado" class="form-control money" aria-describedby="valor_solicitadoHelp" value="<?= $this->data['item']->valor_solicitado ?>">
                <small id="valor_solicitadoHelp" class="form-text text-muted">Valor total já solicitado do item (calculado a cada pedido).</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="termo_referência_origem">Quantidade Total:</label>
                <input type="number" placeholder="0" id="termo_referência_origem" name="qtd_total" class="form-control" aria-describedby="qtd_totalHelp" value="<?= $this->data['item']->qtd_total ?>">
                <small id="qtd_totalHelp" class="form-text text-muted">Quantidade total disponibilizada.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_disponivel">Quantidade Disponível:</label>
                <input type="number" placeholder="0" id="qtd_disponivel" name="qtd_disponivel" class="form-control" aria-describedby="qtd_disponivelHelp" value="<?= $this->data['item']->qtd_disponivel ?>">
                <small id="qtd_disponivelHelp" class="form-text text-muted">Quantidade do itens disponíveis (calculado a cada pedido).</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="valor_solicitado">Quantidade Solicitada:</label>
                <input type="number" placeholder="0" id="qtd_solicitada" name="qtd_solicitada" class="form-control" aria-describedby="qtd_solicitadaHelp" value="<?= $this->data['item']->qtd_solicitada ?>">
                <small id="qtd_solicitadaHelp" class="form-text text-muted">Quantidade solicitada do item (calculado a cada pedido)</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="5"><?= $this->data['item']->descricao ?></textarea>
                <small id="descricaoHelp" class="form-text text-muted">Descrição detalhada do item conforme ATA.</small>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar"><span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
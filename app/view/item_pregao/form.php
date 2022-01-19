<?php include_once( __APP_VIEW__ . '/default/pregao_head.php'); ?>
<form action="<?= $this->action("ItemPregao", "save"); ?>" method="post">
    <?php if ($this->data['item']->_id > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data['item']->_id ?>">
    <?php endif; ?>
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="cod_item_pregao">Código Item:</label>
                <input type="number" id="cod_item_pregao" name="cod_item_pregao" class="form-control" aria-describedby="cod_item_pregaoHelp" value="<?= $this->data['item']->cod_item_pregao ?>">
                <small id="cod_item_pregaoHelp" class="form-text text-muted">Numero do item.</small>
            </div>
        </div>         
        <div class="col">
            <div class="form-group">
                <label for="fornecedor">Fornecedor:</label>
                <input type="text" id="fornecedor" name="fornecedor" class="form-control" aria-describedby="fornecedorHelp" value="<?= $this->data['item']->fornecedor ?>">
                <small id="fornecedorHelp" class="form-text text-muted">CNPJ e Nome.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="3"><?= $this->data['item']->descricao ?></textarea>
                <small id="descricaoHelp" class="form-text text-muted">Descrição detalhada do item conforme ATA.</small>
            </div>
        </div>
    </div>    
    <div class="row">        
        <div class="col">
            <div class="form-group">
                <label for="natureza_despesa">Natureza de Despesa (ND):</label>
                <select id="natureza_despesa" name="natureza_despesa" class="form-control" aria-describedby="natureza_despesaHelp">
                    <option value="33.90.30" <?= $this->data['item']->natureza_despesa == '33.90.30' ? "selected" : "" ?>>Material de Consumo</option>
                    <option value="33.90.39" <?= $this->data['item']->natureza_despesa == '33.90.39' ? "selected" : "" ?>>Serviços de Terceiros Pessoa Jurídica</option>
                    <option value="44.90.52" <?= $this->data['item']->natureza_despesa == '44.90.52' ? "selected" : "" ?>>Material Permanente</option>
                    <option value="44.90.40" <?= $this->data['item']->natureza_despesa == '44.90.40' ? "selected" : "" ?>>Serviços de Tecnologia da Informação e Comunicação</option>
                    <option value="33.90.40" <?= $this->data['item']->natureza_despesa == '33.90.40' ? "selected" : "" ?>>Comunicação de Dados</option>
                </select>
                <small id="natureza_despesaHelp" class="form-text text-muted">Classificação</small>
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
                <label for="unidade">Unidade:</label>
                <input type="text" id="unidade" name="unidade" class="form-control" aria-describedby="unidadeHelp" value="<?= $this->data['item']->unidade ?>">
                <small id="unidadeHelp" class="form-text text-muted">Unidade (Metro, Litro, Unidade, etc).</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_total">Quantidade Total:</label>
                <input type="number" placeholder="0" id="qtd_total" name="qtd_total" class="form-control" aria-describedby="qtd_totalHelp" value="<?= $this->data['item']->qtd_total ?>">
                <small id="qtd_totalHelp" class="form-text text-muted">Quantidade total disponibilizada.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_solicitada">Quantidade Solicitada:</label>
                <input type="number" placeholder="0" id="qtd_solicitada" name="qtd_solicitada" class="form-control" aria-describedby="qtd_solicitadaHelp" value="<?= $this->data['item']->qtd_solicitada ?>">
                <small id="qtd_solicitadaHelp" class="form-text text-muted">Calculado a cada pedido</small>
            </div>
        </div>        
        <div class="col">
            <div class="form-group">
                <label for="qtd_disponivel">Quantidade Disponível:</label>
                <input type="number" placeholder="0" id="qtd_disponivel" name="qtd_disponivel" class="form-control" aria-describedby="qtd_disponivelHelp" value="<?= $this->data['item']->qtd_disponivel ?>">
                <small id="qtd_disponivelHelp" class="form-text text-muted">Calculado a cada pedido.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="qtd_minima">Quantidade minima:</label>
                <input type="number" placeholder="0" id="qtd_minima" name="qtd_minima" class="form-control" aria-describedby="qtd_minimaHelp" value="<?= $this->data['item']->qtd_minima ?>">
                <small id="qtd_minimaHelp" class="form-text text-muted">Se não possuir inserir Zero.</small>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar"><span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
<?php
include_once( __APP_VIEW__ . '/default/natureza_despesa.php'); 
use function TPPA\CORE\basic\pr;
?>

<form action="<?= $this->action("Demanda", "save"); ?>" method="post">
    <?php if ($this->data->_id > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data->_id ?>"><br>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nome">Nome Item:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data->nome ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome do Item. Ex.: Monitor de computador</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="5"><?= $this->data->descricao ?></textarea>
                <small id="descricaoHelp" class="form-text text-muted">Descrição Ex: Monitor de 24 polegadas com definição Full HD.</small>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col">
            <div class="form-group">
                <label for="continuado">Continuado:</label>
                <select id="continuado" name="continuado" class="form-control" aria-describedby="continuadoHelp">
                    <option <?= $this->data->continuado == "true" ? "selected" : "" ?> value="true" >SIM</option>
                    <option <?= $this->data->continuado == "false" ? "selected" : "" ?> value="false">NÃO</option>
                </select>
                <small id="continuadoHelp" class="form-text text-muted">O Item deve ser adquirido periodicamente.</small>
            </div>
        </div>       
        <div class="col">
            <div class="form-group">
                <label for="media_consumo_ano">Média de consumo anual:</label>
                <input type="number" id="media_consumo_ano" name="media_consumo_ano" class="form-control" aria-describedby="media_consumo_anoHelp" value="<?= $this->data->media_consumo_ano ?>">
                <small id="media_consumo_anoHelp" class="form-text text-muted">Previsão de consumo periódico.</small>
            </div>
        </div>               
        <?php natureza_despesa($this->data->natureza_despesa); ?>  
        <div class="col">
            <div class="form-group">
                <label for="catmat">Catmat:</label>
                <input type="text" id="catmat" name="catmat" class="form-control" aria-describedby="catmatHelp" value="<?= $this->data->catmat ?>">
                <small id="catmatHelp" class="form-text text-muted">Código do Catálogo de materiais.</small>
            </div>
        </div>           
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea class="form-control" id="observacao" name="observacao" class="form-control" aria-describedby="observacaoHelp" rows="5"><?= $this->data->observacao ?></textarea>
                <small id="observacaoHelp" class="form-text text-muted">Qualquer observação necessária.</small>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar"><span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
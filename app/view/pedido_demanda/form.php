<?php
use function TPPA\CORE\basic\pr;
pr($this->data);
?>

<form action="<?= $this->action("PedidoDemanda", "save"); ?>" method="post">
    <?php if ($this->data->_id > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data->_id ?>">
    <?php endif; ?>
    <input type="hidden" id="demanda_id" name="demanda_id" value="<?= $this->data->demanda_id ?>">
    <div class="row">
        <div class="col-9">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data->nome ?>">
                <small id="nomeHelp" class="form-text text-muted">Identificar a demanda. Ex: Ano 2022</small>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="ativo">Ativo:</label>
                <select id="ativo" name="ativo" class="form-control" aria-describedby="ativoHelp">
                    <option <?= $this->data->ativo == "true" ? "selected" : "" ?> value="true" >SIM</option>
                    <option <?= $this->data->ativo == "false" ? "selected" : "" ?> value="false">NÃO</option>
                </select>
                <small id="ativoHelp" class="form-text text-muted">Ativo ou inativo.</small>
            </div>
        </div>         
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="5"><?= $this->data->descricao ?></textarea>
                <small id="descricaoHelp" class="form-text text-muted">Descrição de como será realizada a atual demanda.</small>
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
    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar">
        <span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
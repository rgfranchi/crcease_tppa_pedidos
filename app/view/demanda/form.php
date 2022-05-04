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
                <label for="nome">Nome Demanda:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data->nome ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome da Demanda. Ex.: Aquisição de materiais</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" class="form-control" aria-describedby="descricaoHelp" rows="5"><?= $this->data->descricao ?></textarea>
                <small id="descricaoHelp" class="form-text text-muted">Descrição dos objetivos a serem atingidos pela demanda.</small>
            </div>
        </div>
    </div>

    <div class="row">        
        <div class="col">
            <div class="form-group">
                <label for="ativo">Ativo:</label>
                <select id="ativo" name="ativo" class="form-control" aria-describedby="ativoHelp">
                    <option <?= $this->data->ativo == "true" ? "selected" : "" ?> value="true" >SIM</option>
                    <option <?= $this->data->ativo == "false" ? "selected" : "" ?> value="false">NÃO</option>
                </select>
                <small id="ativoHelp" class="form-text text-muted">Ativo ou inativo.</small>
            </div>
        </div>       
        <?php natureza_despesa($this->data->natureza_despesa); ?>    
        <div class="col">
            <div class="form-group">
                <label for="natureza">Natureza:</label>
                <select id="natureza" name="natureza" class="form-control" aria-describedby="naturezaHelp">
                    <option <?= $this->data->natureza == "Atividade" ? "selected" : "" ?> value="Atividade" >ATIVIDADE</option>
                    <option <?= $this->data->natureza == "Projeto" ? "selected" : "" ?> value="Projeto">PROJETO</option>
                </select>
                <small id="naturezaHelp" class="form-text text-muted">Continuado (Atividade) ou Unica Execução (Projeto).</small>
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
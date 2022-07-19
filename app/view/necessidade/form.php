<?php
use TPPA\CORE\BasicFunctions;
use function TPPA\CORE\basic\pr;
// pr($this->data);
$basicFunctions = new BasicFunctions();
?>
<form action="<?= $this->action("Necessidade", "save"); ?>" method="post">
    <?php if ($this->data['_id'] > 0) : ?>
        <input type="hidden" id="_id" name="_id" value="<?= $this->data['_id'] ?>"><br>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" aria-describedby="nomeHelp" value="<?= $this->data['nome'] ?>">
                <small id="nomeHelp" class="form-text text-muted">Nome de identificação da necessicidade.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="objeto">Objeto:</label>
                <input type="text" id="objeto" name="objeto" class="form-control" aria-describedby="objetoHelp" value="<?= $this->data['objeto'] ?>">
                <small id="objetoHelp" class="form-text text-muted">Objeto da necessiades.</small>
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
                <label for="justificativa_necessidade">Justificativa da Necessidade:</label>
                <textarea class="form-control" id="justificativa_necessidade" name="justificativa_necessidade" class="form-control" aria-describedby="justificativaNecessidadeHelp" rows="5"><?= $this->data['justificativa_necessidade'] ?></textarea>
                <small id="justificativaNecessidadeHelp" class="form-text text-muted">Justificar o porque é necessário executar este projeto.</small>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="projeto">Projeto:</label>
                <textarea class="form-control" id="projeto" name="projeto" class="form-control" aria-describedby="projetoHelp" rows="5"><?= $this->data['projeto'] ?></textarea>
                <small id="projetoHelp" class="form-text text-muted">Descrição do projeto projeto.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="integrante_tecnico">Integrante Técnico:</label>
                <input type="text" id="integrante_tecnico" name="integrante_tecnico" class="form-control" aria-describedby="integrante_tecnicoHelp" value="<?= $this->data['integrante_tecnico'] ?>">
                <small id="integrante_tecnicoHelp" class="form-text text-muted">Responsável Tecnicamente pelo projeto.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="integrante_requisitante">Integrante Requisitante:</label>
                <input type="text" id="integrante_requisitante" name="integrante_requisitante" class="form-control" aria-describedby="integrante_requisitanteHelp" value="<?= $this->data['integrante_requisitante'] ?>">
                <small id="integrante_requisitanteHelp" class="form-text text-muted">Responsável pela demanda.</small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="projeto">Observações:</label>
                <textarea class="form-control" id="observacao" name="observacao" class="form-control" aria-describedby="observacaoHelp" rows="5"><?= $this->data['observacao'] ?></textarea>
                <small id="observacaoHelp" class="form-text text-muted">Quaisquer que se faça necessária.</small>
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
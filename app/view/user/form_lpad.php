<?php
// use function TPPA\CORE\basic\pr;
// pr($this->data);
?>

<form action="<?= $this->action("User", "save_lpad"); ?>" method="post">
    <input type="hidden" name="_id" value='0' />    
    <input type="hidden" name="password" value='' />
    <input type="hidden" name="grupo" value='BASICO' />
    <input type="hidden" name="tipo_cadastro" value='SISTEMA' />
    
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="login">login:</label>
                <input readonly="readonly" type="text" aria-label="disabled" id="login" name="login" class="form-control"  aria-describedby="loginHelp" value="<?= $this->data->login ?>">
                <small id="loginHelp" class="form-text text-muted">Login de acesso ao sistema (nome de guerra + iniciais).</small>
            </div>
        </div>         
        <div class="col">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required="required" aria-describedby="nomeHelp" value="">
                <small id="nomeHelp" class="form-text text-muted">Ex: 1T Rafael GUERRA Franchi.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="setor">Setor:</label>
                <select class="custom-select" name="setor" required="required" aria-describedby="setorHelp">
                    <option value="">Selecione um setor</option>
                    <?php foreach (setores() as $value) : ?>
                        <?php if($value ===  $this->data->setor) : ?>
                            <option selected value="<?=$value?>"><?=$value?></option>
                        <?php else : ?>
                            <option value="<?=$value?>"><?=$value?></option>   
                        <?php endif; ?>                
                    <?php endforeach; ?>
                </select>
                <small id="setorHelp" class="form-text text-muted">Setor do usuário.</small>
            </div> 
        </div>    
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea class="form-control" id="observacao" name="observacao" class="form-control" aria-describedby="observacaoHelp" rows="5" ></textarea>
                <small id="observacaoHelp" class="form-text text-muted">Informações se necessário.</small>
            </div>
        </div>
    </div>    
    <button type="submit" class="btn btn-success btn-icon-split" value="Enviar"><span class="icon text-white-50">
        <i class="fas fa-check"></i>
        </span>
        <span class="text">Salvar</span>
    </button>
</form>
<?php
// use function TPPA\CORE\basic\pr;
// pr($this->data);
?>

<form action="<?= $this->action("User", "my_info_update"); ?>" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= $this->data['_id'] ?>">
    <input type="hidden" name="ativo" value='true' />
    <input type="hidden" name="tipo_cadastro" value='<?= $this->data['tipo_cadastro'] ?>' />
    <input type="hidden" name="grupo" value='<?= $this->data['grupo'] ?>' />
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="login">login:</label>
                <input  <?= $this->data['tipo_cadastro'] == "SISTEMA" ? "readonly='readonly'" : "required='required'" ?>  type="text" aria-label="disabled" id="login" name="login" class="form-control"  aria-describedby="loginHelp" value="<?= $this->data['login'] ?>">
                <small id="loginHelp" class="form-text text-muted">Login de acesso ao sistema (nome de guerra + iniciais).</small>
            </div>
        </div>    
            
        <div class="col">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required="required" aria-describedby="nomeHelp" value="<?= $this->data['nome'] ?>">
                <small id="nomeHelp" class="form-text text-muted">Ex: 1T Rafael GUERRA Franchi.</small>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="setor">Setor:</label>
                <select class="custom-select" name="setor" required="required" aria-describedby="setorHelp">
                    <option value="">Selecione um setor</option>
                    <?php foreach (setores() as $value) : ?>
                        <?php if($value ===  $this->data['setor']) : ?>
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
                <label for="password">Senha:</label>
                <input <?= $this->data['tipo_cadastro'] == "SISTEMA" ? "readonly='readonly'" : "" ?>  type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" value='' />
                <small id="passwordHelp" class="form-text text-muted">Se não acessa a rede do CRCEA-SE.</small>
            </div>
        </div>    
        
        <div class="col">            
            <div class="form-group">
                <label for="grupo">Grupo:</label>
                <select disabled="disabled" class="custom-select" name="grupo" required="required"  >
                    <option value="">Selecione um Grupo</option>
                    <?php foreach (grupos() as $key => $value) : ?>
                        <?php if($key === $this->data['grupo']) : ?>
                            <option selected value="<?=$key?>"><?=$value?></option>
                        <?php else : ?>
                            <option value="<?=$key?>"><?=$value?></option>   
                        <?php endif; ?>                
                    <?php endforeach; ?>
                </select>
                <small id="grupoHelp" class="form-text text-muted">Grupo de acesso.</small>
            </div>           
        </div>
        
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea class="form-control" id="observacao" name="observacao" class="form-control" aria-describedby="observacaoHelp" rows="5" ><?= $this->data['observacao'] ?></textarea>
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
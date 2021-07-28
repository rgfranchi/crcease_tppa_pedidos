<h1>PREGAO</h1>
<?php pr($this->data); ?>
<form action="<?= $this->action("PregaoItens", "save"); ?>" method="post">
    <?php if ($this->data->_id > 0) : ?>
        <input type="text" id="_id" name="_id" value="<?= $this->data->_id ?>"><br>
    <?php endif; ?>
    <label for="nome">Pregão ID:</label><br>
    <input type="text" id="pregao_id" name="pregao_id" value="<?= $this->data->pregao_id ?>"><br>
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" value="<?= $this->data->nome ?>"><br>
    <label for="descricao">Descrição:</label><br>
    <input type="text" id="descricao" name="descricao" value="<?= $this->data->descricao ?>"><br>
    <label for="valor_unitario">Valor Unitário:</label><br>
    <input type="text" id="valor_unitario" name="valor_unitario" value="<?= $this->data->valor_unitario ?>"><br>
    <label for="valor_solicitado">Valor Solicitado:</label><br>
    <input type="text" id="valor_solicitado" name="valor_solicitado" value="<?= $this->data->valor_solicitado ?>"><br>
    <label for="qtd_total">Quantidade Total:</label><br>
    <input type="text" id="qtd_total" name="qtd_total" value="<?= $this->data->qtd_total ?>"><br>
    <label for="qtd_solicitada">Quantidade Solicitada:</label><br>
    <input type="text" id="qtd_solicitada" name="qtd_solicitada" value="<?= $this->data->qtd_solicitada ?>"><br>
    <label for="qtd_disponivel">Quantidade Disponível:</label><br>
    <input type="text" id="qtd_disponivel" name="qtd_disponivel" value="<?= $this->data->qtd_disponivel ?>"><br>
    <input type="submit" value="Enviar">
</form>
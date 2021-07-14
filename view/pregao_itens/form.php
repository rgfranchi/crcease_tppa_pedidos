<h1>PREGAO</h1>
<form action="<?= $this->action("Pregao", "save"); ?>" method="post">
    <?php if($this->data->_id > 0) : ?>
        <input type="text" id="_id" name="_id" value="<?= $this->data->_id ?>"><br>
    <?php endif; ?>
    <label for="nome">Pregão:</label><br>
    <input type="text" id="nome" name="nome" value="<?= $this->data->nome ?>"><br>
    <label for="objeto">Objeto:</label><br>
    <input type="text" id="objeto" name="objeto" value="<?= $this->data->objeto ?>"><br>
    <label for="valor_total">Valor Total:</label><br>
    <input type="text" id="valor_total" name="valor_total" value="<?= $this->data->valor_total ?>"><br>
    <label for="valor_solicitado">Valor Solicitado:</label><br>
    <input type="text" id="valor_solicitado" name="valor_solicitado" value="<?= $this->data->valor_solicitado ?>"><br>
    <label for="qtd_total">Quantidade Total:</label><br>
    <input type="text" id="qtd_total" name="qtd_total" value="<?= $this->data->qtd_total ?>"><br>
    <label for="qtd_disponivel">Quantidade Disponível:</label><br>
    <input type="text" id="qtd_disponivel" name="qtd_disponivel" value="<?= $this->data->qtd_disponivel ?>"><br>
    <input type="submit" value="Enviar">
</form>
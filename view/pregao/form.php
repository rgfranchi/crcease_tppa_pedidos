<?php
include(__ROOT__ . '/domain/Pregoes.php');
echo '<h1>PREGAO</h1>';
$object = (object) $this->data;
pr($this->data);
pr($object);
?>
<form action="<?= $this->action("Pregao", "insert"); ?>" method="post">
    <? if (isset($object->id)) { ?>
        <input type="text" id="_id" name="_id" value="<?= $object->id ?>"><br>
    <? } ?>
    <label for="nome">Pregão:</label><br>
    <input type="text" id="name" name="name" value="<?= $object->nome ?>"><br>
    <label for="objeto">Objeto:</label><br>
    <input type="text" id="objeto" name="objeto" value="<?= $object->objeto ?>"><br>
    <label for="valor_total">Valor Total:</label><br>
    <input type="text" id="valor_total" name="valor_total" value="<?= $object->valor_total ?>"><br>
    <label for="valor_solicitado">Valor Solicitado:</label><br>
    <input type="text" id="valor_solicitado" name="valor_solicitado" value="<?= $object->valor_solicitado ?>"><br>
    <label for="qtd_solicitada">Quantidade Solicitada:</label><br>
    <input type="text" id="qtd_solicitada" name="qtd_solicitada" value="<?= $object->qtd_solicitada ?>"><br>
    <label for="qtd_disponivel">Quantidade Disponível:</label><br>
    <input type="text" id="qtd_disponivel" name="qtd_disponivel" value="<?= $object->qtd_disponivel ?>"><br>
    <input type="submit" value="Enviar">
</form>
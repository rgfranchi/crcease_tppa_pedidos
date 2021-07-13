<style>
table, th, td {
  border: 1px solid black;
}

th, td {
  padding: 10px;
}
</style>

<table border:'2'>
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Objeto</th>
    <th>Valor Total</th>
    <th>Valor Solicitado</th>
    <th>Quantidade Disponível</th>
    <th>Quantidade Solicitada</th>
    <th>Ação</th>
  </tr>
  <?php foreach($this->data as $row) : ?>
  <tr>
    <td><?=$row->_id ?></td>
    <td><?=$row->nome ?></td>
    <td><?=$row->objeto ?></td>
    <td><?=$row->valor_total ?></td>
    <td><?=$row->valor_solicitado ?></td>
    <td><?=$row->qtd_disponivel ?></td>
    <td><?=$row->qtd_solicitada ?></td>
    <td><a href="<?= $this->action("Pregao", "edit", array('id' => $row->_id)); ?>" >EDIT</a></td>
  </tr>
  <?php endforeach; ?>
</table>





<?php
pr($this->data);
echo "INDEX PREGAO";



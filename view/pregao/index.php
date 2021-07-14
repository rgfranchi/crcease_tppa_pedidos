<style>
table, th, td {
  border: 1px solid black;
}

th, td {
  padding: 10px;
}
</style>
<?php pr($this->data); ?>

<table border:'2'>
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Objeto</th>
    <th>Valor Total</th>
    <th>Valor Solicitado</th>
    <th>Quantidade Total</th>
    <th>Quantidade Disponível</th>
    <th>Ação</th>
  </tr>
  <?php foreach($this->data as $row) : ?>
  <tr>
    <td><?=$row->_id ?></td>
    <td><?=$row->nome ?></td>
    <td><?=$row->objeto ?></td>
    <td><?=$row->valor_total ?></td>
    <td><?=$row->valor_solicitado ?></td>
    <td><?=$row->qtd_total ?></td>
    <td><?=$row->qtd_disponivel ?></td>
    <td>
      <a href="<?= $this->action("Pregao", "edit", array('id' => $row->_id)); ?>" >EDIT</a>
      <a href="<?= $this->action("Pregao", "delete", array('id' => $row->_id)); ?>" >DELETE</a>
      <a href="<?= $this->action("PregaoItens", "index", array('pregao_id' => $row->_id)); ?>" >ITENS</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
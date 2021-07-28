<style>
  table,
  th,
  td {
    border: 1px solid black;
  }

  th,
  td {
    padding: 10px;
  }
</style>

<?php pr($this->data) ?>
<div>

  <div><?= $this->data->nome; ?></div>
  <div><?= $this->data->objeto ?></div>
  <div><?= $this->data->valor_solicitado ?></div>
  <div><?= $this->data->qtd_disponivel ?></div>
  <a href="<?= $this->action("PregaoItens", "add", array('pregao_id' => $this->data->_id)); ?>">ADD ITEM</a>
</div>
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
  <?php foreach ($this->data as $key => $row) : ?>
    <tr>
      <td><?= $key ?></td>
      <td><?= $row->nome ?></td>
      <td><?= $row->objeto ?></td>
      <td><?= $row->valor_total ?></td>
      <td><?= $row->valor_solicitado ?></td>
      <td><?= $row->qtd_total ?></td>
      <td><?= $row->qtd_disponivel ?></td>
      <td>
        <a href="<?= $this->action("Pregao", "edit", array('id' => $key)); ?>">EDIT</a>
        <a href="<?= $this->action("Pregao", "delete", array('id' => $key)); ?>">DELETE</a>
        <a href="<?= $this->action("PregaoItens", "index", array('id' => $key)); ?>">ITENS</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
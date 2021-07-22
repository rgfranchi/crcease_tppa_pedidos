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


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pregão</h1>
<p class="mb-4">Pregões em .... </a></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><a href="<?= urlController("Pregao", 'add') ?>">Adicionar</a></h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
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
        </thead>
        <tfoot>
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
        </tfoot>
        <tbody>
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row->_id  corrigir campos .... ?></td>
              <td><?= $row->nome ?></td>
              <td><?= $row->objeto ?></td>
              <td><?= $row->valor_total ?></td>
              <td><?= $row->valor_solicitado ?></td>
              <td><?= $row->qtd_total ?></td>
              <td><?= $row->qtd_disponivel ?></td>
              <td>
                <a href="<?= $this->action("Pregao", "edit", array('id' => $row->_id)); ?>">EDIT</a>
                <a href="<?= $this->action("Pregao", "delete", array('id' => $row->_id)); ?>">DELETE</a>
                <a href="<?= $this->action("PregaoItens", "index", array('pregao_id' => $row->_id)); ?>">ITENS</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



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
  <?php foreach ($this->data as $row) : ?>
    <tr>
      <td><?= $row->_id ?></td>
      <td><?= $row->nome ?></td>
      <td><?= $row->objeto ?></td>
      <td><?= $row->valor_total ?></td>
      <td><?= $row->valor_solicitado ?></td>
      <td><?= $row->qtd_total ?></td>
      <td><?= $row->qtd_disponivel ?></td>
      <td>
        <a href="<?= $this->action("Pregao", "edit", array('id' => $row->_id)); ?>">EDIT</a>
        <a href="<?= $this->action("Pregao", "delete", array('id' => $row->_id)); ?>">DELETE</a>
        <a href="<?= $this->action("PregaoItens", "index", array('pregao_id' => $row->_id)); ?>">ITENS</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
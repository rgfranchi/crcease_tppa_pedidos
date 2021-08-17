<?php include_once 'pregao_item.php'; ?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      <a href="<?= $this->action("PregaoItem", "add", array('pregao_id' => $this->data['pregao']->_id)); ?>">Adicionar</a> |
      <a href="<?= $this->action("PregaoItem", "upload_file", array('pregao_id' => $this->data['pregao']->_id)); ?>">Carregar Arquivo</a>
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <th>ID</th>
          <th>COD</th>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Valor Unitário</th>
          <th>Qtd Disponível</th>
          <th>Ação</th>
        </thead>
        <tfoot>
          <th>ID</th>
          <th>COD</th>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Valor Unitário</th>
          <th>Qtd Disponível</th>
          <th>Ação</th>
        </tfoot>
        <?php foreach ($this->data['itens'] as $row) : ?>
          <tr>
            <td><?= $row->_id ?></td>
            <td><?= $row->cod_item_pregao ?></td>
            <td><?= $row->nome ?></td>
            <td><?= $row->descricao ?></td>
            <td><?= $row->valor_unitario ?></td>
            <td><?= $row->qtd_disponivel ?></td>
            <td>
              <a href="<?= $this->action("PregaoItem", "edit", array('item_id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
              <a href="<?= $this->action("PregaoItem", "delete", array('item_id' => $row->_id)); ?>" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php include_once( __ROOT__ . '/app/view/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      <a href="<?= $this->action("ItemPregao", "add", array('pregao_id' => $this->data['pregao']->_id)); ?>">Adicionar</a> |
      <a href="<?= $this->action("ItemPregao", "upload_file", array('pregao_id' => $this->data['pregao']->_id)); ?>">Carregar Arquivo</a> |
      <a href="<?= $this->action("ItemPregao", "download_index", array('pregao_id' => $this->data['pregao']->_id)); ?>" >Gerar Arquivo</a> |
      <a href="<?= $this->action("ItemPregao", "delete_all", array('pregao_id' => $this->data['pregao']->_id)); ?>" class="deleteAll" >Excluir Todos</a> |
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <th>Nº</th>
          <th>Descrição</th>
          <th>Fornecedor</th>
          <th>Valor Unitário</th>
          <th>Qtd Disponível</th>
          <th>Ação</th>
        </thead>
        <tfoot>
          <th>Nº</th>
          <th>Descrição</th>
          <th>Fornecedor</th>
          <th>Valor Unitário</th>
          <th>Qtd Disponível</th>
          <th>Ação</th>
        </tfoot>
        <?php foreach ($this->data['itens'] as $row) : ?>
          <tr>
            <td><?= $row->cod_item_pregao ?></td>
            <td><?= $row->descricao ?></td>
            <td><?= $row->fornecedor ?></td>
            <td><?= $row->valor_unitario ?></td>
            <td><?= $row->qtd_disponivel ?></td>
            <td class="table-action">
              <a href="<?= $this->action("ItemPregao", "edit", array('item_id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
              <a href="<?= $this->action("ItemPregao", "delete", array('item_id' => $row->_id)); ?>" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
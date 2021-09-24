<?php include_once( __ROOT__ . '/view/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Setor</th>
            <th>Solicitante</th>
            <th>Status</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Setor</th>
                <th>Solicitante</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data['pedido'] as $row) : ?>
            <tr>
              <td><?= $row->setor ?></td>
              <td><?= $row->solicitante ?></td>
              <td><?= $row->status ?></td>
              <td class="table-action">
                <a href="<?= $this->action("PedidoPregao", "edit_itens", array('pedido_pregao_id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="ITENS"><i class="fas fa-list"></i></a>
                <a href="<?= $this->action("PedidoPregao", "edit_status", array('pedido_pregao_id' => $row->_id)); ?>" class="btn-sm btn-secondary btn-circle" title="STATUS"><i class="fas fa-anchor"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
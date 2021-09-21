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
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row->setor ?></td>
              <td><?= $row->solicitante ?></td>
              <td><?= $row->status ?></td>
              <td class="table-action">
                <a href="<?= $this->action("PedidoPregao", "consult_itens", array('pedido_pregao_id' => $row->_id)); ?>" class="btn-sm btn-info btn-circle" title="ITENS"><i class="fas fa-list"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
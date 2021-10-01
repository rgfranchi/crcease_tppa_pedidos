<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Pregão</h1> -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Data Vencimento</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Data Vencimento</th>
            <th>Ação</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row->nome ?></td>
              <td><?= $row->objeto ?></td>
              <td style="color:<?= $row->data_vencimento_color ?>"><?= $row->data_vencimento ?></td>
              <td class="table-action">
                <a href="<?= $this->action("PedidoPregao", "edit", array('pregao_id' => $row->_id)); ?>" class="btn-sm btn-warning btn-circle" title="SOLICITAÇÕES"><i class="fas fa-list"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
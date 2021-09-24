<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Pregão</h1> -->
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
            <th>Nome</th>
            <th>Objeto</th>
            <th>Valor Solicitado</th>
            <th>Vencimento</th>
            <th>Ativo</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Valor Solicitado</th>
            <th>Vencimento</th>
            <th>Ativo</th>
            <th>Ação</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row->nome ?></td>
              <td><?= $row->objeto ?></td>
              <td><?= $row->valor_solicitado ?></td>
              <td style="color:<?= $row->data_vencimento_color ?>"><?= $row->data_vencimento ?></td>
              <td><?= $row->ativo === "true" ? "SIM" : "NÃO" ?></td>
              <td class="table-action">
                <a href="<?= $this->action("Pregao", "edit", array('id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
                <a href="<?= $this->action("Pregao", "delete", array('id' => $row->_id)); ?>" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR"><i class="fas fa-trash"></i></a>
                <a href="<?= $this->action("ItemPregao", "index", array('pregao_id' => $row->_id)); ?>" class="btn-sm btn-warning btn-circle" title="ITENS"><i class="fas fa-list"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
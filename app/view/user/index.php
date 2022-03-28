<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Login</th>
            <th>Nome</th>
            <th>Setor</th>
            <th>Grupo</th>
            <th>Cadastro</th>
            <th>Ativo</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Login</th>
            <th>Nome</th>
            <th>Setor</th>
            <th>Grupo</th>
            <th>Cadastro</th>
            <th>Ativo</th>
            <th>Ação</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row->login ?></td>
              <td><?= $row->nome ?></td>
              <td><?= $row->setor ?></td>
              <td><?= $row->grupo ?></td>
              <td><?= $row->tipo_cadastro ?></td>
              <td><?= $row->ativo === "true" ? "SIM" : "NÃO" ?></td>
              <td class="table-action">
                <a href="<?= $this->action("User", "edit", array('id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
                <a href="<?= $this->action("User", "delete", array('id' => $row->_id)); ?>" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Pregão</h1> -->
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_index"); ?>" >Exportar</a>
    </h6>    
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Data Vencimento</th>
            <th title="Rascunho/Aprovado/Concluído" >Qtd.</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Data Vencimento</th>
            <th>Qtd.</th>
            <th>Ação</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row['nome'] ?></td>
              <td><?= $row['objeto'] ?></td>
              <td style="color:<?= $row['data_vencimento_color'] ?>"><?= $row['data_limite_solicitacao'] ?></td>
              <td><?= $row['qtd_pedidos'] ?></td>
              <td class="table-action">
                <a href="<?= $this->action("PedidoPregao", "edit_pedido", array('pregao_id' => $row['_id'])); ?>" class="btn-sm btn-warning btn-circle" title="SOLICITAÇÕES"><i class="fas fa-list"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
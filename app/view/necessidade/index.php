<?php

use function TPPA\CORE\basic\pr;
// pr($this->data);
?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      <a class="btn btn-primary btn-sm" href="<?= $this->action("Necessidade", 'add') ?>">Adicionar</a>
      <a class="btn btn-primary btn-sm" href="<?= $this->action("Necessidade", "download_index"); ?>" >Exportar</a>
    </h6>    
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Nome</th>
            <th>Objeto</th>
            <th>Ação</th>
          </tr>
        </tfoot>
        <tbody>
            <?php foreach ($this->data as $row) : ?>
                <tr>
                    <td><?= $row['nome'] ?></td>
                    <td><?= $row['objeto'] ?></td>
                    <td class="table-action">
                        <a href="<?= $this->action("Necessidade", "edit", array('id' => $row['_id'])); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR"><i class="fas fa-edit"></i></a>
                        <a href="<?= $this->action("Necessidade", "delete", array('id' => $row['_id'])); ?>" class="btn-sm btn-danger btn-circle delete_others" related="Pedidos e Itens" title="EXCLUIR"><i class="fas fa-trash"></i></a>
                        <a href="<?= $this->action("Necessidade", "add_itens", array('necessidade_id' => $row['_id'])); ?>" class="btn-sm btn-warning btn-circle" title="ITENS"><i class="fas fa-list"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?> 
          <!-- <?php foreach ($this->data as $row) : ?>
            <tr>
              <td><?= $row['nome'] ?></td>
              <td><?= $row['objeto'] ?></td>
              <td style="color:<?= $row['data_vencimento_color'] ?>"><?= $row['data_limite_solicitacao'] ?></td>
              <td><?= $row['qtd_pedidos'] ?></td>
              <td class="table-action">
                <a href="<?= $this->action("PedidoPregao", "edit_pedido", array('pregao_id' => $row['_id'])); ?>" class="btn-sm btn-warning btn-circle" title="SOLICITAÇÕES"><i class="fas fa-list"></i></a>
              </td>
            </tr>
          <?php endforeach; ?> -->
        </tbody>
      </table>
    </div>
  </div>
</div>
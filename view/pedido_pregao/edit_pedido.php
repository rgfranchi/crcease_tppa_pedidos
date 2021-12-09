<?php include_once( __ROOT__ . '/view/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
    <?php if($this->data['pregao']->data_vencimento_color != "red") : ?> 
      <a href="<?= $this->action("PedidoPregao", "add_itens", array('pregao_id' => $this->data['pregao']->_id)); ?>">NOVA SOLICITAÇÃO</a>  | 
    <?php endif; ?> 
    Cores: <span class="text-secondary">Não inciado</span>, <span class="text-warning">Aguardando Ação</span>, <span class="text-success">Fim Etapa</span> e <span class="text-info">Finalizado</span> 
    | <a href="<?= $this->action("PedidoPregao", "download_edit_pedido", array("pregao_id" => $this->data['pregao']->_id)); ?>" >Exportar</a>
    </h6>
    
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Setor</th>
            <th>Solicitante</th>
            <th>Status</th>
            <th>#Credito</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Setor</th>
                <th>Solicitante</th>
                <th>Status</th>
                <th>#Credito</th>
                <th>Ação</th>
            </tr>
        </tfoot>
        <tbody>
          <?php foreach ($this->data['pedido'] as $row) : ?>
            <tr>
              <td><?= $row->setor ?></td>
              <td><?= $row->solicitante ?></td>
              <td><?= $row->status ?></td>
              <td>
                <?= $row->hashCredito ?>
              </td>
              <td class="table-action">
                <?php 
                  //Status Solicitado
                  $btItensStyle = 'success';
                  $btSolicitadoStyle = 'warning';
                  $btAprovadoStyle = 'secondary';
                  $btExcluirStyle = 'danger';
                  //Itens já solicitados
                  if($row->status != 'SOLICITADO') {
                    $btItensStyle = 'info';
                  }
                  // Itens aprovados
                  if($row->status == 'APROVADO') {
                    $btSolicitadoStyle = 'success';
                    $btAprovadoStyle = 'warning';
                  }
                  // Habilita para solicitação de crédito.
                  $hashEnabled = false;
                  if($row->status == 'APROVADO' || !empty($row->hashCredito)) {
                    $hashEnabled = true;
                  } 
                  // Item já aprovado e com credito em andamento.
                  if($row->status != 'APROVADO' && $hashEnabled) {
                    $btSolicitadoStyle = 'info';
                    $btAprovadoStyle = 'warning';
                  }
                  // Finalizado o pedido.
                  if($row->status == 'EMPENHADO') {
                    $btAprovadoStyle = 'info';
                    $btExcluirStyle = 'secondary';
                  }
                ?>                
                <a href="<?= $this->action("PedidoPregao", "edit_itens", array('pedido_pregao_id' => $row->_id)); ?>" class="btn-sm btn-<?=$btItensStyle ?> btn-circle" title="EDITAR"><i class="fas fa-list"></i></a>
                <?php if(!is_null($urlSolicitado = urlController("PedidoPregao", "edit_solicitado", array('pedido_pregao_id' => $row->_id)))) : ?>
                  <a href="<?=$urlSolicitado ?>" class="btn-sm btn-<?=$btSolicitadoStyle ?> btn-circle" title="ENCAMINHAR"><i class="fas fa-anchor"></i></a>
                <?php endif; ?>
                <?php if(!is_null($urlAprovado = urlController("PedidoPregao", "edit_aprovado", array('pregao_id' => $row->pregao_id, 'pedido_status' => $row->status, 'hash_credito' => empty($row->hashCredito) ? "" : $row->hashCredito )))) : ?>
                  <a href="<?=$urlAprovado ?>" class="btn btn-sm btn-<?=$btAprovadoStyle?> btn-circle <?= $hashEnabled  ? '' : 'disabled' ?>" title="APROVADOS ENCAMINHAR"><i class="fas fa-hand-holding-usd"></i></a>
                <?php endif; ?>
                <?php if(!is_null($urlDelete = urlController("PedidoPregao", "delete", array('pedido_pregao_id' => $row->_id, 'pedido_status' => $row->status, 'hash_credito' => empty($row->hashCredito) ? "" : $row->hashCredito )))) : ?>
                  <a href="<?=$urlDelete ?>" class="btn btn-sm btn-<?=$btExcluirStyle?> btn-circle delete <?= $btExcluirStyle == "secondary"  ? 'disabled' : '' ?>"  title="EXCLUIR"><i class="fas fa-trash"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
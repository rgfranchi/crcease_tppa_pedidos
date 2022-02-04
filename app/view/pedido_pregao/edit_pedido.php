<?php include_once( __APP_VIEW__ . '/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
    <?php if($this->data['pregao']->data_vencimento_color != "red") : ?> 
      <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "add_itens", array('pregao_id' => $this->data['pregao']->_id)); ?>">NOVA SOLICITAÇÃO</a> 
    <?php endif; ?> 
    <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_edit_pedido", array("pregao_id" => $this->data['pregao']->_id)); ?>" >Exportar</a>
    <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_edit_aprovado", array("pregao_id" => $this->data['pregao']->_id, "hash_credito" => "")); ?>" >Exportar TOTAL ITENS</a>
    Cores: <span class="text-secondary">Não inciado</span>, <span class="text-warning">Aguardando Ação</span>, <span class="text-success">Fim Etapa</span> e <span class="text-info">Finalizado</span> 
      
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
            <th>Data</th>
            <th>#Credito</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
              <th>Setor</th>
              <th>Solicitante</th>
              <th>Status</th>
              <th>Data</th>
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
              <td><?= $row->create ?></td>
              <td>
                <?= $row->hashCredito ?>
              </td>
              <td class="table-action">
                <?php 
                  //Status Rascunho
                  $btRascunhoStyle = 'secondary';
                  $btAprovadoStyle = 'secondary';
                  $btAprovadoEnabled = false;
                  $btCreditoStyle = 'secondary';
                  $btCreditoEnabled = false;
                  $btExcluirStyle = 'danger';
                  $btExcluirEnabled = true;
                  //Itens já solicitados
                  if($row->status == 'RASCUNHO') {
                    $btRascunhoStyle = 'warning';
                  }
                  // Itens aprovados
                  if($row->status == 'AGUARDANDO APROVAÇÃO') {
                    $btRascunhoStyle = 'success';
                    $btAprovadoStyle = 'warning';
                    $btAprovadoEnabled = true;
                  }                  
                  // Itens aprovados
                  if(
                    $row->status == 'APROVADO'
                  ) {
                    $btRascunhoStyle = 'info';
                    $btAprovadoStyle = 'success';
                    $btCreditoStyle = 'warning';
                    $btAprovadoEnabled = true;
                    $btCreditoEnabled = true;
                  }

                  if(
                    $row->status == 'CREDITO SOLICITADO' ||
                    $row->status == 'CREDITADO' ||
                    $row->status == 'EMPENHO SOLICITADO'
                  ) {
                    $btRascunhoStyle = 'info';
                    $btAprovadoStyle = 'info';
                    $btCreditoStyle = 'warning';
                    $btAprovadoEnabled = true;
                    $btCreditoEnabled = true;
                  }

                  // Finalizado o pedido.
                  if($row->status == 'EMPENHADO') {
                    $btRascunhoStyle = 'info';
                    $btAprovadoStyle = 'info';
                    $btCreditoStyle = 'info';
                    $btAprovadoEnabled = true;
                    $btCreditoEnabled = true;
                    $btExcluirEnabled = false;
                  }

                  if($row->status == 'EXCLUIDO') {
                    $btRascunhoStyle = 'secondary';
                    $btAprovadoStyle = 'secondary';
                    $btCreditoStyle = 'secondary';
                    $btAprovadoEnabled = false;
                    $btCreditoEnabled = false;
                    $btExcluirEnabled = false;
                  }
                ?>                
                <a href="<?= $this->action("PedidoPregao", "edit_itens", array('pedido_pregao_id' => $row->_id)); ?>" class="btn-sm btn-<?=$btRascunhoStyle ?> btn-circle" title="RASCUNHO"><i class="fas fa-list"></i></a>
                <?php if(!is_null($urlSolicitado = $this->basicFunctions->urlController("PedidoPregao", "edit_solicitado", array('pedido_pregao_id' => $row->_id)))) : ?>
                  <a href="<?=$urlSolicitado ?>" class="btn btn-sm btn-<?=$btAprovadoStyle ?> btn-circle <?= $btAprovadoEnabled  ? '' : 'disabled' ?>" title="APROVAR"><i class="fas fa-anchor"></i></a>
                <?php endif; ?>
                <?php if(!is_null($urlAprovado = $this->basicFunctions->urlController("PedidoPregao", "edit_aprovado", array('pregao_id' => $row->pregao_id, 'pedido_status' => $row->status, 'hash_credito' => empty($row->hashCredito) ? "" : $row->hashCredito )))) : ?>
                  <a href="<?=$urlAprovado ?>" class="btn btn-sm btn-<?=$btCreditoStyle?> btn-circle <?= $btCreditoEnabled  ? '' : 'disabled' ?>" title="CREDITO"><i class="fas fa-hand-holding-usd"></i></a>
                <?php endif; ?>
                <?php if(!is_null($urlDelete = $this->basicFunctions->urlController("PedidoPregao", "delete", array('pedido_pregao_id' => $row->_id, 'pedido_status' => $row->status, 'hash_credito' => empty($row->hashCredito) ? "" : $row->hashCredito )))) : ?>
                  <a href="<?=$urlDelete ?>" class="btn btn-sm btn-<?=$btExcluirStyle?> btn-circle delete <?= $btExcluirEnabled  ? '' : 'disabled' ?>"  title="EXCLUIR"><i class="fas fa-trash"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
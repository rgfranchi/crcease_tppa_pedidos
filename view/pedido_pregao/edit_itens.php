<?php include_once( __ROOT__ . '/view/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= isset($this->data['pedido']->_id) ? $this->data['pedido']->_id : 0 ?>">
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    <input type="hidden" id="itens_pedido" name="itens_pedido" value="SOLICITADO">
    <?php $disableEdit = $this->data['pedido']->status !== 'SOLICITADO' ?>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
          Setor: <?= $this->data['pedido']->setor; ?> |
          Solicitante: <?= $this->data['pedido']->solicitante; ?> |
          Status: <?= $this->data['pedido']->status; ?> 
          <?=$disableEdit ? "" : " | <input type='submit'  value='SALVAR' />" ?> 
          
      </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <th>ID</th>
            <th>COD</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor Unitário</th>
            <th>Qtd Disponível</th>
            <th>Ação</th>
          </thead>
          <tfoot>
            <th>ID</th>
            <th>COD</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor Unitário</th>
            <th>Qtd Disponível</th>
            <th>Ação</th>
          </tfoot>
          <?php foreach ($this->data['itens'] as $row) : ?>
            <tr>
              <td><?= $row->_id ?></td>
              <td><?= $row->cod_item_pregao ?></td>
              <td><?= $row->nome ?></td>
              <td><?= $row->descricao ?></td>
              <td><?= $row->valor_unitario ?></td>
              <td><?= $row->qtd_disponivel ?></td>
              <td class="table-action">
                <input type='number' <?=$disableEdit ? "disabled" : "" ?> name='itens_pedido[<?= $row->_id ?>]' value='<?= isset($this->data['pedido']->itens_pedido[$row->_id]) ? $this->data['pedido']->itens_pedido[$row->_id] : 0 ?>' min=0 max=<?= $row->qtd_disponivel ?>   />
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </form>
</div>
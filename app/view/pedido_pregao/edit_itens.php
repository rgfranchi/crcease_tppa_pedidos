<?php
  // use function TPPA\CORE\basic\pr;
  $enableEdit = $this->data['pedido']->status  === "RASCUNHO";
  include_once(  __APP_VIEW__ . '/default/pregao_head.php'); 
?>
<div class="card shadow mb-4">
  <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= isset($this->data['pedido']->_id) ? $this->data['pedido']->_id : 0 ?>">
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    <input type="hidden" id="pregao_id" name="solicitante" value="<?=$this->data['pedido']->solicitante;?>">
    <input type="hidden" id="pregao_id" name="setor" value="<?=$this->data['pedido']->setor;?>">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">
        <div>
          <row>
            <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_edit_itens", array("pedido_pregao_id" => $this->data['pedido']->_id)); ?>" >Exportar</a>
            <?php if($enableEdit) : ?>
              <button class="btn btn-primary btn-sm" type="submit" name="status" value="RASCUNHO">SALVAR RASCUNHO</button>
              <button class="btn btn-success btn-sm" type="submit" name="status" value="AGUARDANDO APROVAÇÃO">SALVAR ENCAMINHAR</button> 
            <?php endif; ?>
              Setor: <?=$this->data['pedido']->setor;?> |
              Solicitante: <?=$this->data['pedido']->solicitante;?> |
              Status: <?= $this->data['pedido']->status; ?> 
            <?php $enableEdit = @$_SESSION['login']['admin'] ? true : $enableEdit; ?> 
          </row>
        </div>
      </h6>
      <div>TOTAL:R$ <span id="total_pedido">XX.XXXX,XX</span></div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <th>Nº</th>
            <th>Descrição</th>
            <th>Fornecedor</th>
            <th>Valor Unitário</th>
            <th>Qtd Disponível</th>
            <th>Quantidade</th>
          </thead>
          <tfoot>
            <th>Nº</th>
            <th>Descrição</th>
            <th>Fornecedor</th>
            <th>Valor Unitário</th>
            <th>Qtd Disponível</th>
            <th>Quantidade</th>
          </tfoot>
          <?php foreach ($this->data['itens'] as $row) : ?>
            <tr>
              <td><?= $row->cod_item_pregao ?></td>
              <td><?= $row->descricao ?></td>
              <td><?= $row->fornecedor ?></td>
              <td class="valor_unitario" id='<?=$row->_id?>'><?= $row->valor_unitario ?></td>
              <td><?= $row->qtd_disponivel ?></td>
              <td class="table-action">
                <input type='number' <?=$enableEdit ? "" : "disabled" ?> class="itens_pedido" id='item_id_<?= $row->_id ?>' name='itens_pedido[<?= $row->_id ?>]' value='<?= isset($this->data['pedido']->itens_pedido[$row->_id]) ? $this->data['pedido']->itens_pedido[$row->_id] : 0 ?>' min=0 max=<?= $row->qtd_disponivel ?>  onchange="sumPedidos()" />
                <?php if(isset($this->data['invalid_itens']) && isset($this->data['invalid_itens'][$row->_id])) : ?>
                  <p style="color: red;">QTD. INDISPONÍVEL (<?=$this->data['invalid_itens'][$row->_id]->qtd_disponivel?>)</p>
                <?php endif; ?>
              </td>              
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </form>
</div>

<?php $this->template_js[] = 'edit_itens' ?>
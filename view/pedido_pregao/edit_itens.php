<?php include_once( __ROOT__ . '/view/default/pregao_head.php'); ?>
<div class="card shadow mb-4">
  <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= isset($this->data['pedido']->_id) ? $this->data['pedido']->_id : 0 ?>">
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    <input type="hidden" id="status" name="status" value="SOLICITADO">
    <?php $enableEdit = true; ?>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <?php
          $solicitante = isset($this->data['pedido']->solicitante) ? $this->data['pedido']->solicitante : "";
          $setor = isset($this->data['pedido']->setor) ? $this->data['pedido']->setor : "";
        ?>
        <?php if(isset($this->data['pedido']->_id) && $this->data['pedido']->_id > 0) : ?>
          <?php $enableEdit = (isset($_SESSION['login']['admin']) && $_SESSION['login']['admin'] == true) ? $_SESSION['login']['admin'] : false; // $this->data['pedido']->status === 'SOLICITADO' ?>
          <div>
            Setor: <?= $setor; ?> |
            Solicitante: <?= $solicitante; ?> |
            Status: <?= $this->data['pedido']->status; ?> 
            <?=$enableEdit ? " | <input type='submit'  value='SALVAR' />" : "" ?> 
            | <a href="<?= $this->action("PedidoPregao", "download_edit_itens", array("pedido_pregao_id" => $this->data['pedido']->_id)); ?>" >Exportar</a>
          </div>
        <?php else : ?>
          <div class="input-group">
            <div class="input-group-prepend">
              <select class="custom-select" name="setor" required="required">
                <option value="">Selecione um setor</option>
                <?php foreach (setores() as $value) : ?>
                  <?php if($value ===  $setor) : ?>
                    <option selected value="<?=$value?>"><?=$value?></option>
                  <?php else : ?>
                    <option value="<?=$value?>"><?=$value?></option>   
                  <?php endif; ?>                
                <?php endforeach; ?>
              </select>
            </div>
            <input 
              type="text" 
              value="<?=isset($solicitante) ? $solicitante : '' ?>"
              class="form-control" 
              aria-label="Text input with dropdown button"
              name="solicitante" 
              required="required" 
              title="Nome do Solicitante"
              placeholder="Solicitante"
              />
            <input type="submit" value="SALVAR" />

          </div>          
        <?php endif; ?>
        
      </h6>
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
              <td><?= $row->valor_unitario ?></td>
              <td><?= $row->qtd_disponivel ?></td>
              <td class="table-action">
                <input type='number' <?=$enableEdit ? "" : "disabled" ?> name='itens_pedido[<?= $row->_id ?>]' value='<?= isset($this->data['pedido']->itens_pedido[$row->_id]) ? $this->data['pedido']->itens_pedido[$row->_id] : 0 ?>' min=0 max=<?= $row->qtd_disponivel ?>   />
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
<?php include_once( __ROOT__ . '/view/pregao_item/pregao_item.php'); ?>
<div class="card shadow mb-4">
  <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
    <input type="hidden" id="_id" name="_id" value="<?= isset($this->data['pedido']->_id) ? $this->data['pedido']->_id : 0 ?>">
    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
    
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        <div class="input-group">
          <div class="input-group-prepend">
            <select class="custom-select" name="setor" required="required">
              <option value="">Selecione um setor</option>
              <?php foreach (setores() as $value) : ?>
              <option value="<?=$value?>"><?=$value?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <input 
            type="text" 
            class="form-control" aria-label="Text input with dropdown button"
            name="solicitante" 
            required="required" 
            title="Nome do Solicitante"   
            placeholder="Solicitante" />
            <input type="submit" value="SALVAR" />
        </div>  
        
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
                <input type='number' name='itens_id[<?= $row->_id ?>]' min=0 max=<?= $row->qtd_disponivel ?>   />
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </form>
</div>
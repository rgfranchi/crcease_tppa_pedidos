<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Pregão</h1> -->
<!-- DataTales Example -->
<div class="card shadow mb-1">
  <div class="card-header py-2">
    <form action="<?= $this->action("PedidoPregaoPesquisar", "index"); ?>" method="post">
        <div class="row" >
            <div class="col-8">
                <div class="form-group">
                    <input type="text" id="find_value" name="find_value" class="form-control" placeholder="Insira o valor de pesquisa" value="<?= $this->data['find_value'] ?>" > 
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <select class="form-control" id="ativo" name="ativo" >
                      <option value="true" <?=$this->data['ativo'] == "true" ? "selected" : "" ?> >ATIVO</option>
                      <option value="false" <?=$this->data['ativo'] == "false" ? "selected" : "" ?> >INATIVO</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary btn-icon-split" value="Enviar">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Buscar</span>
                </button>    
            </div>
        </div>                    
        <small class="text-muted">Pregao (nome objeto TR PAG) Item (código descricao fornecedor) Pedido (setor solicitante status)</small>
    </form>
  </div>
  <div class="card-body">
  <?php foreach ($this->data as $type => $type_row) : ?>
    <?php if(!is_array($type_row)) { continue; } ?>
    <?php foreach ($type_row as $row) : ?>
      <div id='row' class="card mb-2">
        <div id="pregao" class="card border-left-<?=($type == "pregao") ? 'success' : 'primary'?>" >
          <p style="margin:0;"><a href="<?= $this->action("PedidoPregao", "edit_pedido", array('pregao_id' => $row['_id'])); ?>" target="_blank" title="SOLICITAÇÕES">
              <?=$row['nome']?>
            </a>
            <?=' - '.$row['objeto'] . ' - ' . $row['termo_referencia_origem'] .' - '.$row['numero_processo_PAG']?>
          </p>
        </div>

        <div id="item_pregao" class="card border-left-<?=($type == "item_pregao") ? 'success' : 'primary'?>">
          <?php foreach($row['item_pregao'] as $itemPregao) : ?>
            <?=$itemPregao['cod_item_pregao'] . ' - ' . $itemPregao['descricao'] . ' - ' . $itemPregao['valor_unitario'] . ' - ' . $itemPregao['fornecedor'] . ' - ' . $itemPregao['natureza_despesa'] . '<br>'?>
          <?php endforeach; ?>
        </div>

        <div id="pedido_pregao" class="card border-left-<?=($type == "pedido_pregao") ? 'success' : 'primary'?>">
          <?php foreach($row['pedido_pregao'] as $pedidoPregao) : ?>
            <p style="margin:0;">
              <a href="<?= $this->action("PedidoPregao", "edit_itens", array('pedido_pregao_id' => $pedidoPregao['_id'])); ?>" target="_blank" title="PEDIDO">
                <?= $pedidoPregao['setor'] . ' - ' . $pedidoPregao['solicitante'] . ' - ' . $pedidoPregao['status'] . (isset($pedidoPregao['hashCredito']) ? ' - ' . @$pedidoPregao['hashCredito'] : "") . '<br>' ?>
              </a>
            </p>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endforeach; ?>
  </div>
</div>
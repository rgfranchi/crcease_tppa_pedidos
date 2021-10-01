<div class="card shadow mb-4">
    <div class="card-header py-1">
        <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
            <input type="hidden" id="_id" name="_id" value="<?= $this->data['pedido']->_id ?>">
            <div class="input-group">
            <?php if (in_array($this->data['pedido']->status,$this->data['status'])) : ?>
                <div class="input-group-prepend">
                    <select class="custom-select" name="status" required="required">
                    <?php foreach ($this->data['status'] as $value) : ?>
                    <option value="<?=$value?>" <?= $value == $this->data['pedido']->status ? "selected" : "" ?>><?=$value?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="ATUALIZAR" />
                <?php else : ?>
                    <p>STATUS: <?=$this->data['pedido']->status ?></p>
                <?php endif; ?>                
            </div>
        </form>
    </div>
    <?php include_once( __ROOT__ . '/view/default/pedido_cards.php'); ?>
    <?php include_once( __ROOT__ . '/view/default/pregao_card.php'); ?>

    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Itens Solicitados</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th>COD</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Qtd Pedido</th>
                    <th>Valor Pedido</th>
                </thead>
                <tfoot>
                    <th>COD</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Qtd Pedido</th>
                    <th>Valor Pedido</th>
                </tfoot>
                <?php foreach ($this->data['pedido']->itens_pedido as $row) : ?>
                    <tr>
                        <td><?= $row->cod_item_pregao ?></td>
                        <td><?= $row->nome ?></td>
                        <td><?= $row->descricao ?></td>
                        <td><?= $row->fornecedor ?></td>
                        <td><?= $row->valor_unitario ?></td>
                        <td><?= $row->valor_solicitado ?></td>
                        <td><?= $row->qtd_disponivel ?></td>
                        <td><?= $row->qtd_solicitada ?></td>
                        <td><?= $row->pedido_quantidade ?></td>
                        <td><?= $row->pedido_valor ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
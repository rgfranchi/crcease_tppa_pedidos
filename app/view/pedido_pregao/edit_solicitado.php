<?php
use function TPPA\CORE\basic\pr;
$pedido = $this->data['pedido'];
?>
<div class="card shadow mb-4">
    <div class="card-header py-1">
        <h6 class="m-0 font-weight-bold text-primary">

            <?php if($pedido['status'] == 'AGUARDANDO APROVAÇÃO') : ?>
                <form action="<?= $this->action("PedidoPregao", "save"); ?>" method="post">
                    <input type="hidden" id="_id" name="_id" value="<?= $pedido['_id'] ?>">
                    <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $pedido['pregao_id'] ?>">
                    <input type="hidden" id="aprovador" name="aprovador" value="<?= $pedido['aprovador'] ?>">
                    <button class="btn btn-primary btn-sm" type="submit" name="status" value="RASCUNHO">RETORNAR RASCUNHO</button>
                    <button class="btn btn-success btn-sm" type="submit" name="status" value="APROVADO">APROVAR</button> 
                    Aprovador: <?= $pedido['aprovador'] ?>
                </form>
            <?php else : ?>
                STATUS: <?=$pedido['status'] ?> | Aprovado por: <?= $pedido['aprovador'] ?>
            <?php endif; ?>         
        </h6>
    </div>
    <?php include_once(  __APP_VIEW__ . '/default/pedido_cards.php'); ?>
    <?php include_once(  __APP_VIEW__ . '/default/pregao_card.php'); ?>

    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_edit_solicitado", array("pedido_pregao_id" => $pedido['_id'])); ?>" >Exportar</a>
                Itens Solicitados
            </h6>                    
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <th>COD</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Total</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Valor Pedido</th>
                </thead>
                <tfoot>
                    <th>COD</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Valor Unitário</th>
                    <th>Valor Solicitado</th>
                    <th>Qtd Total</th>
                    <th>Qtd Disponível</th>
                    <th>Qtd Solicitada</th>
                    <th>Valor Pedido</th>
                </tfoot>
                <?php foreach ($pedido['itens_pedido'] as $row) : ?>
                    <tr>
                        <td><?= $row['cod_item_pregao'] ?></td>
                        <td><?= $row['descricao'] ?></td>
                        <td><?= $row['fornecedor'] ?></td>
                        <td><?= $row['valor_unitario'] ?></td>
                        <td><?= $row['valor_solicitado'] ?></td>
                        <td><?= $row['qtd_total'] ?></td>
                        <td><?= $row['qtd_disponivel'] ?></td>
                        <td><?= $row['qtd_solicitada'] ?></td>
                        <td><?= $row['valor_solicitado'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
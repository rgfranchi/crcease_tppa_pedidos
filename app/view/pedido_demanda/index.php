<?php
use function TPPA\CORE\basic\pr;

pr($this->data);

?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
        <a class="btn btn-primary btn-sm" href="<?= $this->basicFunctions->urlController("PedidoDemanda", 'add', array('demanda_id' => $this->data['demanda_id'])) ?>">Adicionar</a>
        <!-- <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoDemanda", "download_file"); ?>" >Exportar</a> -->
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Observação</th>
                    <th>Ação</th>
                <tr>
            </thead>
            <tbody>
                <?php foreach ($this->data['pedidoDemanda'] as $row) : ?>
                    <tr>
                        <td><?=$row->nome?></td>
                        <td><?=nl2br($row->descricao)?></td>
                        <td><?=nl2br($row->observacao)?></td>
                        <td class="table-action">
                            <a href="<?= $this->action("PedidoDemanda", "pedidoDemanda", array('id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="Pedido" >
                                <i class="fas fa-list"></i>
                            </a>
                            <a href="<?= $this->action("PedidoDemanda", "update", array('id' => $row->_id)); ?>" class="btn-sm btn-primary btn-circle" title="EDITAR" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</div>
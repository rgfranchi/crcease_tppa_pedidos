<?php
use function TPPA\CORE\basic\pr;
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        Selecione a categoria da necessidade.
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descricao</th>
                    <th>Quantidade</th>
                    <th>Solicitantes</th>
                    <th>Ação</th>
                <tr>
            </thead>
            <tbody>
                <?php foreach ($this->data as $row) : ?>
                    <tr>
                        <td><?=$row->nome?></td>
                        <td><?=$row->descricao?></td>
                        <td><?=$row->total_quantidade?></td>
                        <td><?=implode(",", $row->solicitantes)?></td>
                        <td class="table-action">
                            <a href="<?= $this->action("Demanda", "add_demanda", array('id' => $row->_id)); ?>" class="btn-sm btn-success btn-circle" >
                                <i class="fas fa-cart-plus"></i>
                            </a>
                            <a href="<?= $this->action("Demanda", "edit_demanda", array('id' => $row->_id)); ?>" class="btn-sm btn-warning btn-circle" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</div>
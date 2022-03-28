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
                    <th>Demanda</th>
                    <th>Ação</th>
                <tr>
            </thead>
            <tbody>
                <?php foreach ($this->data as $row) : ?>
                    <tr>
                        <td><?=$row->descricao?></td>
                        <td class="table-action">
                            <a href="<?= $this->action("Demanda", "list_demanda", array('id' => $row->_id)); ?>" class="btn-sm btn-warning btn-circle" >
                                <i class="fas fa-list"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</div>
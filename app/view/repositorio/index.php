<?php
use function TPPA\CORE\basic\pr;
?>

<div class="card shadow mb-4">
<div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
        <a class="btn btn-primary btn-sm" href="<?= $this->basicFunctions->urlController("Repositorio", 'add') ?>">Adicionar</a>
        <!-- <a class="btn btn-primary btn-sm" href="<?= $this->action("Repositorio", "download_file"); ?>" >Exportar</a> -->
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descricao</th>
                    <th>Observação</th>
                    <th>Natureza Despesa</th>
                    <th>Ação</th>
                <tr>
            </thead>
            <tbody>
                <?php foreach ($this->data as $row) : ?>
                    <tr>
                        <td><?=$row->nome?></td>
                        <td><?=$row->descricao?></td>
                        <td><?=$row->observacao?></td>
                        <td><?=$row->natureza_despesa?></td>
                        <td class="table-action">
                            <a href="<?= $this->action("Repositorio", "add_necessidade", array('id' => $row->_id)); ?>" class="btn-sm btn-success btn-circle" >
                                <i class="fas fa-cart-plus"></i>
                            </a>
                            <a href="<?= $this->action("Repositorio", "edit_repositorio", array('id' => $row->_id)); ?>" class="btn-sm btn-warning btn-circle" >
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </div>
</div>
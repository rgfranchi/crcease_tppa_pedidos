
<?php include_once 'pregao_item.php'; ?>
<input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">

<?php
$select = '<select id="typeField"><option>EX 1</option><option>EX 2</option><option>EX 3</option><option>EX 4</option></select>';
?>
continuar......
<div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <th></th>
        <?php foreach (array_keys($this->data['load_file'][0]) as $column_id) : ?>
          <th column_id=<?=$column_id?>><?=$select?> <a href="#" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR COLUNA"><i class="fas fa-trash"></i></a></th>
        <?php endforeach; ?>
        </thead>
        <?php foreach ($this->data['load_file'] as $line_id => $column) : ?>
          <tr line_id='<?= $line_id ?>'>
            <td><a href="#" class="btn-sm btn-danger btn-circle delete" title="EXCLUIR LINHA"><i class="fas fa-trash"></i></a></td>
            <?php foreach ($column as $column_id => $value) : ?>
                <td column_id=<?=$column_id?>> <input type="text" id="data_load" name="data_load[<?=$line_id?>][<?=$column_id?>]" value="<?= $value ?>"></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

<?php 

<?php include_once 'pregao_item.php'; ?>
<input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">

<?php
// cria select para os cabeçalhos
$select = '<select id="typeField" class="typeField" name="typeField[%s]"><option value="null" selected>Não Selecionado</option>';

foreach ($this->data['option_fields'] as $key => $value) {
  $select .= sprintf('<option value="%s">%s</option>', $key, $value);
}

$select .= '</select>';
// <option value="ex1">EX 1</option><option value="ex2">EX 2</option><option value="ex3">EX 3</option><option value="ex4">EX 4</option></select>';
?>
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
      <form enctype="multipart/form-data" id="file_form" action='<?= $this->action("PregaoItem", "upload_file"); ?>' method="post">
        <input type='file' name="spreadsheet" id="file_spreadsheet">
        <input type="hidden" id="pregao_id" name="pregao_id" value="<?= $this->data['pregao']->_id ?>">
      </form>
    </h6>
  </div>
  <div class="card-body">
    <?php if (!isset($this->data['load_file'])) : ?>
      <h3>ARQUIVO NÃO CARREGADO</h3>
    <?php else : ?>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <th></th>
            <?php foreach (array_keys($this->data['load_file'][0]) as $column_id) : ?>
              <th column_id='<?= $column_id ?>'><?= sprintf($select, $column_id) ?> <a href="#" class="btn-sm btn-danger btn-circle column_delete" title="EXCLUIR COLUNA"><i class="fas fa-trash"></i></a></th>
            <?php endforeach; ?>
          </thead>
          <?php foreach ($this->data['load_file'] as $line_id => $column) : ?>
            <tr line_id='<?= $line_id ?>'>
              <td><a href="#" class="btn-sm btn-danger btn-circle row_delete" title="EXCLUIR LINHA"><i class="fas fa-trash"></i></a></td>
              <?php foreach ($column as $column_id => $value) : ?>
                <td column_id=<?= $column_id ?>> <input type="text" id="data_load" name="data_load[<?= $line_id ?>][<?= $column_id ?>]" value="<?= $value ?>"></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php endif ?>
  </div>
</div>

<?php $this->template_js = 'upload_file' ?>

<?php

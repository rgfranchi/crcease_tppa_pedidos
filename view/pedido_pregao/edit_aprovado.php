<div class="card shadow mb-4">
    <div class="card-header py-1">
    <?php if ($this->data['pedido_status'] != "EMPENHADO") : ?>        
        <form action="<?= $this->action("PedidoPregao", "saveMany"); ?>" method="post">
            <input type="hidden" id="pregao_id" name="pregao_id" value="<?= json_encode($this->data['pregao']->_id) ?>">
            <input type="hidden" id="_ids" name="_ids" value="<?= json_encode($this->data['pedidos']['pedidos_id']) ?>">
            <input type="hidden" id="hash_credito" name="hash_credito" value="<?= $this->data['hash_credito'] ?>">
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="custom-select" name="status" required="required">
                    <?php foreach ($this->data['status'] as $value) : ?>
                        <option value="<?=$value?>" <?= $value == $this->data['pedido_status'] ? "selected" : "" ?>><?=$value?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="ATUALIZAR" />
            </div>
        </form>
    <?php else : ?>
        <p>STATUS: <?=$this->data['pedido_status'] ?></p>
    <?php endif; ?>         
    </div>
    <?php include_once( __ROOT__ . '/view/default/pregao_card.php'); ?>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                TOTAL PEDIDOS R$ <?= convertToMoneyBR($this->data['pedidos']['VALOR_TOTAL']) ?>
                | <a href="<?= $this->action("PedidoPregao", "download_edit_aprovado", array(
                    "pregao_id" => $this->data['pregao']->_id,
                    "hash_credito" => $this->data['hash_credito']
                    )); ?>" >Exportar</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive scrollTopTable">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <?php foreach ($this->data['pedidos']['HEADER'] as $field => $field_value) : ?>
                        
                        <?php
                            $px = 100;
                            switch($field) {
                                case 'descricao' :
                                    $px = 800;
                                    break;
                                case 'valor_unitario' :
                                    $px = 180;
                                    break;
                                case 'fornecedor' :
                                    $px = 400;
                                    break;
                                case 'sub_total' :
                                    $px = 170;
                                    break;
                            }
                        ?>
                        
                        <th style="min-width: <?=$px?>px;" field='<?=$field?>' ><?=$field_value ?></th>
                    <?php endforeach; ?>
                    </thead>
                    <tbody>
                    <?php foreach ($this->data['pedidos']['BODY'] as $id => $field_value) : ?>
                        <tr id='<?=$id?>' >
                        <?php foreach (array_keys($this->data['pedidos']['HEADER']) as $field_name) : ?>
                            <?php 
                                $valor = isset($field_value[$field_name]) ? $field_value[$field_name] : "-";
                                $valor = in_array($field_name,array('sub_total','valor_unitario')) ?  convertToMoneyBR($valor) : $valor; 
                            ?>
                            <td field='<?=$field_name?>' ><?= $valor ?></td>
                        <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $this->template_js = array('scrollTop') ?>    
</div>
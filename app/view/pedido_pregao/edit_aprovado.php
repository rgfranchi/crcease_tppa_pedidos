<?php
use function TPPA\CORE\basic\pr;
?>
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
    <?php include_once(  __APP_VIEW__ . '/default/pregao_card.php'); ?>
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
            <a class="btn btn-primary btn-sm" href="<?= $this->action("PedidoPregao", "download_edit_aprovado", array(
                    "pregao_id" => $this->data['pregao']->_id,
                    "hash_credito" => $this->data['hash_credito']
                    )); ?>" >Exportar</a>    
                TOTAL R$ <?= $basicFunctions->convertToMoneyBR($this->data['pedidos']['total_valor']) ?> | UN <?= $this->data['pedidos']['total_quantidade']; ?>
            </h6>
        </div>
        <?php if(empty($this->data['pedidos']['BODY'])) : ?>
            <div> NÃO POSSUI ITENS PARA EXIBIR. </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive scrollTopTable">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <?php foreach ((array) $this->data['pedidos']['BODY'][0] as $field => $field_value) : ?>
                        
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
                                case 'sub_total_valor' :
                                    $px = 170;
                                    break;
                                case 'sub_total_quantidade' :
                                    $px = 170;
                                    break;
                            }
                            if($field == "_id") {
                                continue;
                            }
                        ?>
                        <?php if(key_exists($field, $this->data['pedidos']['HEADER'])) : ?>
                            <th style="min-width: <?=$px?>px;" field='<?=$field?>' ><?=$this->data['pedidos']['HEADER'][$field] ?></th>
                        <?php else: ?>
                            <?php preg_match('#(.*?)-(.*?)\(#', $field, $match); ?>                        
                            <th style="min-width: 100px;" field="<?=$field?>">
                                <small>
                                <?=$match[1];?>
                                </small><br>
                                <small style="font-size: xx-small;">
                                <?=$match[2]?>
                                </small>
                            </th>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                    </thead>
                    <tbody>
                    <?php foreach ($this->data['pedidos']['BODY'] as $fields) : ?>
                        <tr id='<?=$fields->_id?>' >
                        <?php unset($fields->_id) ?>
                        <?php foreach ($fields as $field_key => $field_value ) : ?>
                            <td field='<?=$field_key?>' ><?= $field_key === "sub_total_valor" ? $basicFunctions->convertToMoneyBR($field_value) : $field_value ?></td>
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
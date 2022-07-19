<?php
use function TPPA\CORE\basic\pr;
pr($this->data);

corrigir data ao autializar estaus ..
// die;
// mantem relação de ID de PedidoPregao.
$pedidos_id = [];
?>
<div class="card shadow mb-4">
    <div class="card-header py-1">
    <?php if ($this->data['pedido_status'] != "EMPENHADO") : ?>        
        <form action="<?= $this->action("PedidoPregao", "saveMany"); ?>" method="post">
            <input type="hidden" id="pregao_id" name="pregao_id" value="<?= json_encode($this->data['pregao']['_id']) ?>">
            <input type="hidden" id="_ids" name="_ids" value="<?= json_encode($this->data['pedidos']['pedidos_ids']) ?>">
            <input type="hidden" id="hash_credito" name="hash_credito" value="<?= $this->data['hash_credito'] ?>">
            
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="custom-select" name="status" required="required">
                    <option value="AGUARDANDO APROVAÇÃO">RETORNAR AGUARDANDO APROVAÇÃO</option>
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
                    "pregao_id" => $this->data['pregao']['_id'],
                    "hash_credito" => $this->data['hash_credito']
                    )); ?>" >Exportar</a>    
                TOTAL R$ <?= $this->basicFunctions->convertToMoneyBR($this->data['pedidos']['BODY']['total_valor']) ?> | UN <?= $this->data['pedidos']['BODY']['total_quantidade']; ?>
            </h6>
        </div>
        <?php if(empty($this->data['pedidos']['BODY'])) : ?>
            <div> NÃO POSSUI ITENS PARA EXIBIR. </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive scrollTopTable">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <?php foreach ($this->data['pedidos']['HEADER'] as $field => $show) : ?>
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
                            <?php if(is_array($show)) : ?>
                                <?php $pedidos_id[] = $field; ?>
                                <th style="min-width: 100px;" pedido_id="<?=$field?>">
                                    <small>
                                        <?=$show['setor'] . '-' . $show['status']?>
                                    </small><br>
                                    <small style="font-size: xx-small;">
                                        <?=$show['solicitante']?>
                                    </small>
                                </th> 
                            <?php else: ?>
                                <th style="min-width: <?=$px?>px;" field='<?=$field?>' ><?=$this->data['pedidos']['HEADER'][$field] ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                    <?php foreach ($this->data['pedidos']['BODY'] as $fields) : ?>
                        <?php if(!isset($fields['_id'])) {continue;} ?>
                        <tr item_id='<?=$fields['_id'] ?>'>
                            <td>
                                <?= $fields['cod_item_pregao'] ?>
                            </td>
                            <td>
                                <?= $fields['descricao']  ?>
                            </td>
                            <td>
                                <?= $this->basicFunctions->convertToMoneyBR($fields['valor_unitario'])  ?>
                            </td>
                            <td>
                                <?= $fields['fornecedor']  ?>
                            </td>
                            <td>
                                <?= $this->basicFunctions->convertToMoneyBR($fields['sub_total_valor'])  ?>
                            </td>
                            <td>
                                <?= $fields['sub_total_quantidade'] ?>
                            </td>
                            <?php foreach ($pedidos_id as $position => $key) : $key = str_replace('_','',$key) ?>
                                <td>
                                    <?= isset($fields['pedidos'][$key]) ? $fields['pedidos'][$key]['quantidade'] : 0 ?>
                                </td>
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